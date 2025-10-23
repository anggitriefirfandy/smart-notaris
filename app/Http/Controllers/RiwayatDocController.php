<?php
namespace App\Http\Controllers;

use App\Models\LogAktivitasModel;
use App\Models\RiwayatDocModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class RiwayatDocController extends Controller
{

    // public function index()
    // {
    //     $data['riwayat'] = riwayat_doc::leftJoin('lembar_kerja', 'riwayat_dokumen.lembar_id', '=', 'lembar_kerja.id')
    //         ->select('riwayat_dokumen.*', 'lembar_kerja.*')
    //         ->get();
    //     return $data;
    //     return view('pages.riwayat_doc.riwayat_doc', $data);
    // }
    public function index()
    {
        // Get the authenticated user's ID
        $authenticatedUserId = Auth::id();
        // return $authenticatedUserId;
        // Fetch the data with the joins and select clauses
        $data['riwayat'] = RiwayatDocModel::leftJoin('lembar_kerja', 'riwayat_dokumen.lembar_id', '=', 'lembar_kerja.id')
            ->leftJoin('notaris', 'lembar_kerja.notaris_id', '=', 'notaris.id')
            ->select(
                'riwayat_dokumen.*',
                'lembar_kerja.*',
                'notaris.user_id as notaris_user_id',
                'notaris.nama as notaris_nama',
                'riwayat_dokumen.uid as uid_riwdoc',
                'riwayat_dokumen.status as status_riwdoc'
            )
            ->get();
        // Filter the results based on the authenticated user's ID
        $data['riwayat'] = $data['riwayat']->filter(function ($item) use ($authenticatedUserId) {
            return $item->notaris_user_id == $authenticatedUserId;
        });
        // return $data;

        // You can return the view if needed
        return view('pages.riwayat_doc.riwayat_doc', $data);
    }
    public function downloadDocument($uid)
    {
        $riwayat = RiwayatDocModel::where('uid', $uid)->firstOrFail();

        $filePath = public_path($riwayat->dokumen);

        return response()->download($filePath, 'dokumen.pdf');
    }

    public function downloadUploadedFile($file)
    {
        $filePath = public_path('dokumen/' . $file);

        return response()->download($filePath);
    }

    public function changestatusriwdoc(Request $request, $id)
    {
        RiwayatDocModel::where('uid', $id)->update([
            'status' => $request->status,
        ]);

        // Menggunakan response JSON untuk memberitahu frontend bahwa perubahan berhasil
        return response()->json([
            'success' => true,
            'msg'     => 'Berhasil merubah status hasil kerja',
        ]);
    }

    public function create($lembar_kerja_id)
    {
        $data['riwayat'] = RiwayatDocModel::all();

        return view('riwayat_doc.riwayat_doc', $data);
    }

    public function store(Request $request)
    {
        // return $request;
        $validatedData = $request->validate([
            'lembar_id'     => 'required',
            'bank_id'       => 'required',
            'notaris_id'    => 'required',
            'uploaded_file' => 'required|mimes:pdf|max:102400',
            'keterangan'    => 'required',
        ]);

        $currentUser = Auth::user();
        $bank_id     = $currentUser->uid;

        if ($request->hasFile('uploaded_file')) {
            $uploadPath = public_path('dokumen'); // Direktori penyimpanan file

            if (! File::isDirectory($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true, true);
            }

            $file     = $request->file('uploaded_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($uploadPath, $fileName); // Simpan file

            // Gunakan updateOrCreate untuk menyimpan atau memperbarui data berdasarkan lembar_id
            RiwayatDocModel::updateOrCreate(
                ['lembar_id' => $validatedData['lembar_id']], // Kriteria untuk update atau insert
                [
                    'uid'        => Str::uuid(), // UID hanya dibuat jika data baru
                    'bank_id'    => $bank_id,
                    'notaris_id' => $validatedData['notaris_id'],
                    'dokumen'    => 'dokumen/' . $fileName,
                    'status'     => 0,
                    'keterangan' => $validatedData['keterangan'],
                ]
            );
            $logaktivitas                    = new LogAktivitasModel();
            $logaktivitas->lembar_id         = $request->lembar_id;
            $logaktivitas->notaris_id        = $request->notaris_id;
            $logaktivitas->bank_id           = $request->bank_id;
            $logaktivitas->nama_proses       = 'upload dokumen';
            $logaktivitas->created_by        = $currentUser->uid;
            $logaktivitas->uid               = Str::uuid();
            $logaktivitas->tanggal_aktivitas = Carbon::now();
            $logaktivitas->save();
            \Log::info($request->all());

            Alert::success('Sukses', 'Berhasil Upload Dokumen!');
            return redirect('/lembar_kerja');
        }

        return back()->withInput()->with('error', 'Gagal mengunggah dokumen.');
    }

    public function download(Request $request)
    {
        $uuidfile  = $request->query('uuidfile');
        $notarisId = $request->query('notaris_id');
        $bankId    = $request->query('bank_id');
        // return $request->all();
        $document = RiwayatDocModel::where('lembar_id', $request->uuidfile)->first();
        // return $document;
        // Simpan ke log aktivitas
        $currentUser                     = Auth::user();
        $logaktivitas                    = new LogAktivitasModel();
        $logaktivitas->lembar_id         = $uuidfile;
        $logaktivitas->notaris_id        = $notarisId;
        $logaktivitas->bank_id           = $bankId;
        $logaktivitas->nama_proses       = 'download dokumen';
        $logaktivitas->created_by        = $currentUser->uid;
        $logaktivitas->uid               = Str::uuid();
        $logaktivitas->tanggal_aktivitas = Carbon::now();
        $logaktivitas->save();
        return Response::download($document['dokumen']);
    }
}
