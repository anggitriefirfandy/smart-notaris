<?php
namespace App\Http\Controllers;

use App\Models\HasilKerjaModel;
use App\Models\LembarKerjaModel;
use App\Models\LogAktivitasModel;
use App\Models\NotarisModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class HasilKerjaController extends Controller
{
    public function index()
    {
        $data['hasil_kerja'] = HasilKerjaModel::leftJoin('lembar_kerja', 'hasil_kerja.lembar_id', "=", 'lembar_kerja.id')
            ->select('hasil_kerja.*', 'lembar_kerja.*', 'hasil_kerja.uid as uid_kerja', 'hasil_kerja.status as status_kerja')->get();
        // return $data;
        return view('hasil_kerja.hasil_kerja', $data);
    }
    public function changestatus(Request $request, $id)
    {
        HasilKerjaModel::where('uid', $id)->update([
            'status' => $request->status,
        ]);

        // Menggunakan response JSON untuk memberitahu frontend bahwa perubahan berhasil
        return response()->json([
            'success' => true,
            'msg'     => 'Berhasil merubah status hasil kerja',
        ]);
    }

    public function create()
    {
        $notaris      = NotarisModel::all();
        $lembar_kerja = LembarKerjaModel::all();
        return view('hasil_kerja.tambah_hasil_kerja', compact('notaris', 'lembar_kerja'));
    }

    // public function store(Request $request)
    // {
    //     // return $request;
    //     $validatedData = $request->validate([
    //         'lembar_id'     => 'required',
    //         'notaris_id'    => 'required',
    //         'bank_id'       => 'required',
    //         'uploaded_file' => 'required|mimes:pdf|max:102400',
    //     ]);

    //     // Cek apakah sudah ada data dengan lembar_id dan notaris_id yang sama
    //     $existingData = HasilKerjaModel::where('lembar_id', $validatedData['lembar_id'])
    //         ->where('notaris_id', $validatedData['notaris_id'])
    //         ->first();

    //     if ($existingData) {
    //         // Jika sudah ada data, lakukan update
    //         if ($request->hasFile('uploaded_file')) {
    //             $uploadPath = public_path('hasil');

    //             if (! File::isDirectory($uploadPath)) {
    //                 File::makeDirectory($uploadPath, 0755, true, true);
    //             }

    //             $file     = $request->file('uploaded_file');
    //             $fileName = time() . '_' . $file->getClientOriginalName();
    //             $filePath = $file->move($uploadPath, $fileName);

    //             // Update data di database
    //             $existingData->dokumen    = 'hasil/' . $fileName;
    //             $existingData->status     = 0; // Set nilai status ke 0
    //             $existingData->status_doc = 0; // Set nilai status_doc ke 0
    //             $existingData->save();

    //             $currentUser                     = Auth::user();
    //             $logaktivitas                    = new LogAktivitasModel();
    //             $logaktivitas->lembar_id         = $request->lembar_id;
    //             $logaktivitas->notaris_id        = $request->notaris_id;
    //             $logaktivitas->bank_id           = $request->bank_id;
    //             $logaktivitas->nama_proses       = 'upload hasil kerja';
    //             $logaktivitas->created_by        = $currentUser->uid;
    //             $logaktivitas->uid               = Str::uuid();
    //             $logaktivitas->tanggal_aktivitas = Carbon::now();
    //             $logaktivitas->save();

    //             return redirect()->route('lembar_kerja.index')->with('success', 'hasil kerja berhasil diunggah.');
    //         }
    //     } else {
    //         // Jika belum ada data, buat data baru
    //         if ($request->hasFile('uploaded_file')) {
    //             $uploadPath = public_path('hasil');

    //             if (! File::isDirectory($uploadPath)) {
    //                 File::makeDirectory($uploadPath, 0755, true, true);
    //             }

    //             $file     = $request->file('uploaded_file');
    //             $fileName = time() . '_' . $file->getClientOriginalName();
    //             $filePath = $file->move($uploadPath, $fileName);

    //             // Simpan data ke database
    //             $hasil             = new HasilKerjaModel;
    //             $hasil->uid        = Str::uuid();
    //             $hasil->lembar_id  = $validatedData['lembar_id'];
    //             $hasil->notaris_id = $validatedData['notaris_id'];
    //             $hasil->bank_id    = $validatedData['bank_id'];
    //             $hasil->dokumen    = 'hasil/' . $fileName;
    //             $hasil->status     = 0;
    //             $hasil->status_doc = 0;
    //             $hasil->save();

    //             $currentUser                     = Auth::user();
    //             $logaktivitas                    = new LogAktivitasModel();
    //             $logaktivitas->lembar_id         = $request->lembar_id;
    //             $logaktivitas->notaris_id        = $request->notaris_id;
    //             $logaktivitas->bank_id           = $request->bank_id;
    //             $logaktivitas->nama_proses       = 'upload hasil kerja';
    //             $logaktivitas->created_by        = $currentUser->uid;
    //             $logaktivitas->uid               = Str::uuid();
    //             $logaktivitas->tanggal_aktivitas = Carbon::now();
    //             $logaktivitas->save();

    //             return redirect()->route('lembar_kerja.index')->with('success', 'hasil kerja berhasil diunggah.');
    //         }

    //         $currentUser                     = Auth::user();
    //         $logaktivitas                    = new LogAktivitasModel();
    //         $logaktivitas->lembar_id         = $request->lembar_id;
    //         $logaktivitas->notaris_id        = $request->notaris_id;
    //         $logaktivitas->bank_id           = $request->bank_id;
    //         $logaktivitas->nama_proses       = 'upload hasil kerja';
    //         $logaktivitas->created_by        = $currentUser->uid;
    //         $logaktivitas->uid               = Str::uuid();
    //         $logaktivitas->tanggal_aktivitas = Carbon::now();
    //         $logaktivitas->save();
    //     }

    //     return back()->withInput()->with('error', 'Gagal mengunggah hasil kerja.');
    // }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'lembar_id'     => 'required',
            'notaris_id'    => 'required',
            'bank_id'       => 'required',
            'uploaded_file' => 'required|mimes:pdf|max:102400',
        ]);

        $currentUser = Auth::user();

        if ($request->hasFile('uploaded_file')) {
            $uploadPath = public_path('hasil');

            if (! File::isDirectory($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true, true);
            }

            $file     = $request->file('uploaded_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($uploadPath, $fileName); // Simpan file

            // Gunakan updateOrCreate: berdasarkan lembar_id & notaris_id
            $hasil = HasilKerjaModel::updateOrCreate(
                [
                    'lembar_id'  => $validatedData['lembar_id'],
                    'notaris_id' => $validatedData['notaris_id'],
                ],
                [
                    'bank_id'    => $validatedData['bank_id'],
                    'dokumen'    => 'hasil/' . $fileName,
                    'status'     => 0,
                    'status_doc' => 0,
                ]
            );

// Tambahkan uid jika baru
            if ($hasil->wasRecentlyCreated) {
                $hasil->uid = Str::uuid();
                $hasil->save();
            }

            // Log aktivitas
            $logaktivitas                    = new LogAktivitasModel();
            $logaktivitas->lembar_id         = $validatedData['lembar_id'];
            $logaktivitas->notaris_id        = $validatedData['notaris_id'];
            $logaktivitas->bank_id           = $validatedData['bank_id'];
            $logaktivitas->nama_proses       = 'upload hasil kerja';
            $logaktivitas->created_by        = $currentUser->uid;
            $logaktivitas->uid               = Str::uuid();
            $logaktivitas->tanggal_aktivitas = Carbon::now();
            $logaktivitas->save();

            return redirect()->route('lembar_kerja.index')->with('success', 'Hasil kerja berhasil diunggah.');
        }

        return back()->withInput()->with('error', 'Gagal mengunggah hasil kerja.');
    }

    public function upload_hasil($id)
    {
        $data['hasil_kerja'] = LembarKerjaModel::where('uid', $id)->first();
        return view('lembar_kerja.upload_hasil', $data);
    }

    public function download(Request $request)
    {
        $uuidfile  = $request->query('uuidfile');
        $notarisId = $request->query('notaris_id');
        $bankId    = $request->query('bank_id');
        // return $request->all();
        $document = HasilKerjaModel::where('lembar_id', $request->uuidfile)->first();
        // return $document;
        // Simpan ke log aktivitas
        $currentUser                     = Auth::user();
        $logaktivitas                    = new LogAktivitasModel();
        $logaktivitas->lembar_id         = $uuidfile;
        $logaktivitas->notaris_id        = $notarisId;
        $logaktivitas->bank_id           = $bankId;
        $logaktivitas->nama_proses       = 'download Hasil Kerja';
        $logaktivitas->created_by        = $currentUser->uid;
        $logaktivitas->uid               = Str::uuid();
        $logaktivitas->tanggal_aktivitas = Carbon::now();
        $logaktivitas->save();
        return Response::download($document['dokumen']);
    }
}
