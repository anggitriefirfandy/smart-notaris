<?php
namespace App\Http\Controllers;

use App\Models\CoverNoteModel;
use App\Models\CutoffModel;
use App\Models\LembarKerjaModel;
use App\Models\LogAktivitasModel;
use App\Models\NotarisModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class LembarKerjaController extends Controller
{
    public function index()
    {
        try {
            // Ambil user yang sedang login
            $currentuser = Auth::user();

            $query = LembarKerjaModel::leftJoin('notaris', 'lembar_kerja.notaris_id', '=', 'notaris.uid')
                ->leftJoin('bank', 'lembar_kerja.bank_id', '=', 'bank.uid')
                ->leftJoin('riwayat_dokumen', 'lembar_kerja.uid', '=', 'riwayat_dokumen.lembar_id')
                ->leftJoin('hasil_kerja', 'lembar_kerja.uid', '=', 'hasil_kerja.lembar_id')
                ->leftJoin('covernote', 'lembar_kerja.uid', '=', 'covernote.lembar_id')
                ->leftJoin(DB::raw("(SELECT lembar_id, progres FROM log_progres WHERE id = (SELECT MAX(id) FROM log_progres lp WHERE lp.lembar_id = log_progres.lembar_id)) as log_terbaru"), 'lembar_kerja.uid', '=', 'log_terbaru.lembar_id')
                ->select(
                    'lembar_kerja.*',
                    'notaris.nama as notaris_nama',
                    'bank.nama_bank as bank_nama',
                    'riwayat_dokumen.dokumen as dokumen',
                    'hasil_kerja.dokumen as hasil',
                    'covernote.covernote as covernote',
                    'log_terbaru.progres as progres'
                );

            // Jika user adalah Notaris (role_id = 2), filter by notaris_id
            if ($currentuser->role_id == 2) {
                $uidnotaris = optional($currentuser->notaris)->uid;

                if (! $uidnotaris) {
                    return back()->with('error', 'Data notaris tidak ditemukan.');
                }

                $query->where('lembar_kerja.notaris_id', $uidnotaris);
            }

            $data['lembar_kerja'] = $query->get();

            return view('lembar_kerja.lembar_kerja', $data);
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $notaris = NotarisModel::all();

        // Ambil user yang sedang login
        $currentUser = Auth::user();

        // Ambil data user_id dan cabang sesuai dengan user yang sedang login
        $user_id = $currentUser->uid;
        $bank_id = $currentUser->bank_id;

        return view('lembar_kerja.tambah_lembar_kerja', compact('notaris', 'user_id', 'bank_id'));
    }

    public function store(Request $request)
    {
        // return $request;
        // Validasi request
        $request->validate([
            'notaris'          => 'required',
            'nama'             => 'required',
            'detail_pekerjaan' => 'required',
            'keterangan'       => 'required',
            'fee'              => 'required',
        ]);

        // Mendapatkan user yang sedang login
        $currentUser = Auth::user();

        // Ambil cabang_id dari user yang sedang login
        $lembarKerja = new LembarKerjaModel();

        // Mengisi nilai sesuai request
        $lembarKerja->notaris_id       = $request->notaris;
        $lembarKerja->nama             = $request->nama;
        $lembarKerja->detail_pekerjaan = $request->detail_pekerjaan;
        $lembarKerja->keterangan       = $request->keterangan;
        $lembarKerja->fee              = $request->fee;
        $lembarKerja->uid              = Str::uuid();
        $lembarKerja->status           = 0;

        // Menyimpan user_id sesuai user yang login
        $lembarKerja->bank_id = $currentUser->uid;
        $lembarKerja->save();

        $logaktivitas                    = new LogAktivitasModel();
        $logaktivitas->lembar_id         = $lembarKerja->uid;
        $logaktivitas->notaris_id        = $request->notaris;
        $logaktivitas->bank_id           = $currentUser->uid;
        $logaktivitas->nama_proses       = 'Menambahkan lembar kerja';
        $logaktivitas->created_by        = $currentUser->uid;
        $logaktivitas->uid               = Str::uuid();
        $logaktivitas->tanggal_aktivitas = date('Y-m-d');
        $logaktivitas->save();

        // Redirect atau respons ketika data berhasil disimpan
        return redirect()->route('lembar_kerja.index')->with('success', 'Data berhasil disimpan.');
    }

    public function changestatus(Request $request, $uid)
    {
        LembarKerjaModel::where('uid', $uid)->update([
            'status_diterima' => $request->status_diterima,
        ]);

        // Menggunakan response JSON untuk memberitahu frontend bahwa perubahan berhasil
        return response()->json([
            'success' => true,
            'msg'     => 'Berhasil merubah status hasil kerja',
        ]);
    }

    public function changestatusselesai(Request $request, $uid)
    {
        LembarKerjaModel::where('uid', $uid)->update([
            'status_selesai' => $request->status_selesai,
        ]);

        // Menggunakan response JSON untuk memberitahu frontend bahwa perubahan berhasil
        return response()->json([
            'success' => true,
            'msg'     => 'Berhasil merubah status selesai kerja',
        ]);
    }

    public function show(LembarKerjaModel $lembarKerjaModel)
    {
        //
    }

    public function edit($id)
    {

        $data['lembar_kerja'] = LembarKerjaModel::where('uid', $id)->first();
        return view('lembar_kerja.edit_lembar_kerja', $data);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'nama' => 'required',
            'fee'  => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $dataToUpdate = [
            'nama' => $request->nama,
            'fee'  => $request->fee,
        ];

        LembarKerjaModel::where('uid', $id)->update($dataToUpdate);

        return redirect('/lembar_kerja')->with('success', 'Berhasil edit data');
    }
    public function destroy($id)
    {
        $lembar_kerja = LembarKerjaModel::where('uid', $id)->first();

        if (! $lembar_kerja) {
            return redirect('/lembar_kerja')->with('error', 'Lembar Kerja tidak ditemukan');
        }

        $lembar_kerja->delete();

        return redirect('/lembar_kerja')->with('success', 'Berhasil hapus lembar kerja');
    }

    public function upload_berkas($id)
    {
        $data['berkas'] = LembarKerjaModel::where('uid', $id)->first();
        // return $data;
        return view('lembar_kerja.upload_berkas', $data);
    }

    public function tambah_kerjakan($id)
    {
        $data['kerjakan'] = LembarKerjaModel::where('uid', $id)->first();
        // return $data;
        return view('lembar_kerja.tambah_kerjakan', $data);
    }
    public function kerjakan(Request $request)
    {
        // return $request;
        $validatedData = $request->validate([
            'lembar_id'     => 'required',
            'bank_id'       => 'required',
            'notaris_id'    => 'required',
            'uploaded_file' => 'required|mimes:pdf|max:102400',
            'keterangan'    => 'nullable|string',
            'waktu_proses'  => 'nullable',
            'covernote'     => 'nullable',
        ]);

        // Update status di LembarKerjaModel
        LembarKerjaModel::where('uid', $validatedData['lembar_id'])->update([
            'waktu_proses'      => $request->waktu_proses,
            'status_dikerjakan' => 1,
        ]);

        // Upload file
        $fileName = null;
        if ($request->hasFile('uploaded_file')) {
            $uploadPath = public_path('covernote');

            if (! File::isDirectory($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true, true);
            }

            $file     = $request->file('uploaded_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($uploadPath, $fileName);
        }

        // Simpan atau update CoverNoteModel
        CoverNoteModel::updateOrCreate(
            ['lembar_id' => $validatedData['lembar_id']],
            [
                'uid'        => Str::uuid(),
                'bank_id'    => $validatedData['bank_id'],
                'notaris_id' => $validatedData['notaris_id'],
                'covernote'  => $fileName ? 'covernote/' . $fileName : null,
                'status'     => 0,
                'keterangan' => $validatedData['keterangan'] ?? null,
            ]
        );

        // Simpan log aktivitas
        $currentUser                     = Auth::user();
        $logaktivitas                    = new LogAktivitasModel();
        $logaktivitas->uid               = Str::uuid();
        $logaktivitas->lembar_id         = $validatedData['lembar_id'];
        $logaktivitas->notaris_id        = $validatedData['notaris_id'];
        $logaktivitas->bank_id           = $validatedData['bank_id'];
        $logaktivitas->nama_proses       = 'mulai kerjakan';
        $logaktivitas->created_by        = $currentUser->uid;
        $logaktivitas->tanggal_aktivitas = Carbon::now();
        $logaktivitas->save();

        Alert::success('Sukses', 'Berhasil Mulai Kerja Dengan Countdown!');
        return redirect('/lembar_kerja');
    }

    public function getNotif(Request $request)
    {
        try {
            $currentuser = Auth::user();
            $uidnotaris  = $currentuser->notaris->uid;

            $data = LembarKerjaModel::where('notaris_id', $uidnotaris)
                ->where(function ($query) {
                    $query->where('status_diterima', '0')
                        ->orWhereNull('status_diterima');
                })
                ->get();

            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $id     = $request->input('id');
            $status = $request->input('status');

            // Perbarui status di database
            DB::table('lembar_kerja')
                ->where('id', $id)
                ->update(['status_diterima' => $status]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function cutoff()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();

        $data = LembarKerjaModel::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();

        if ($data->isEmpty()) {
            return redirect()->back()->with('warning', 'Tidak ada data untuk disalin.');
        }

        DB::beginTransaction();

        try {
            foreach ($data as $item) {
                CutoffModel::create([
                    'uid'                  => $item->uid,
                    'notaris_id'           => $item->notaris_id,
                    'bank_id'              => $item->bank_id,
                    'nama'                 => $item->nama,
                    'detail_pekerjaan'     => $item->detail_pekerjaan,
                    'status_diterima'      => $item->status_diterima,
                    'status_dikerjakan'    => $item->status_dikerjakan,
                    'status_selesai'       => $item->status_selesai,
                    'status'               => $item->status,
                    'file'                 => $item->file,
                    'waktu_proses'         => $item->waktu_proses,
                    'keterangan'           => $item->keterangan,
                    'fee'                  => $item->fee,
                    'status_tolak_notaris' => $item->status_tolak_notaris,
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil disalin ke tabel cutoff.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyalin data: ' . $e->getMessage());
        }
    }

    public function download(Request $request)
    {
        $uuidfile  = $request->query('uuidfile');
        $notarisId = $request->query('notaris_id');
        $bankId    = $request->query('bank_id');
        // return $request->all();
        $document = CoverNoteModel::where('lembar_id', $request->uuidfile)->first();
        // return $document;
        // Simpan ke log aktivitas
        $currentUser                     = Auth::user();
        $logaktivitas                    = new LogAktivitasModel();
        $logaktivitas->lembar_id         = $uuidfile;
        $logaktivitas->notaris_id        = $notarisId;
        $logaktivitas->bank_id           = $bankId;
        $logaktivitas->nama_proses       = 'download covernote';
        $logaktivitas->created_by        = $currentUser->uid;
        $logaktivitas->uid               = Str::uuid();
        $logaktivitas->tanggal_aktivitas = Carbon::now();
        $logaktivitas->save();
        return Response::download($document['covernote']);
    }
}
