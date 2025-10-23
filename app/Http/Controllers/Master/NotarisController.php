<?php
namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\BankModel;
use App\Models\LembarKerjaModel;
use App\Models\LogAktivitasModel;
use App\Models\NotarisModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class NotarisController extends Controller
{
    public function index()
    {
        $data['notaris'] = NotarisModel::get();
        return view('admin.master_notaris.notaris', $data);
    }

    public function create()
    {
        return view('admin.master_notaris.tambahnotaris');
    }

    public function store(Request $request)
    {
        if ($request->uid) {
            if ($request->hasFile('foto')) {
                $validator = Validator::make($request->all(), [
                    'nama'          => 'required',
                    'jenis_kelamin' => 'required',
                    'foto'          => 'image|mimes:jpeg,png,jpg|max:2048',
                    'nomor_notaris' => 'required',
                    'alamat'        => 'required',
                    'email'         => 'required',
                    'no_hp'         => 'required',
                ]);

                // response error validation
                if ($validator->fails()) {
                    return Redirect::back()->withErrors($validator);
                }
                $name     = $request->file('foto')->getClientOriginalName();
                $filename = time() . '-' . $name;
                $file     = $request->file('foto');
                $file->move(public_path('Image'), $filename);

                NotarisModel::where('uid', $request->uid)->update([
                    'nama'          => $request->nama,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'picture'       => $filename,
                    'nomor_notaris' => $request->nomor_notaris,
                    'alamat'        => $request->alamat,
                    'email'         => $request->email,
                    'no_hp'         => $request->no_hp,

                ]);
                return redirect('/notaris')->with('success', 'Berhasil edit data AAAAAA');
            } else {
                $validator = Validator::make($request->all(), [
                    'nama'          => 'required',
                    'jenis_kelamin' => 'required',
                    'nomor_notaris' => 'required',
                    'alamat'        => 'required',
                    'email'         => 'required',
                    'no_hp'         => 'required',
                ]);
                if ($validator->fails()) {
                    return Redirect::back()->withErrors($validator);
                }

                NotarisModel::where('uid', $request->uid)->update([

                    'nama'          => $request->nama,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'nomor_notaris' => $request->nomor_notaris,
                    'alamat'        => $request->alamat,
                    'email'         => $request->email,
                    'no_hp'         => $request->no_hp,

                ]);
                return redirect('/notaris')->with('success', 'Berhasil edit data BBBB');
            }

        } else {
            $validator = Validator::make($request->all(), [

                'nama'          => 'required',

                'jenis_kelamin' => 'required',

                'foto'          => 'image|mimes:jpeg,png,jpg|max:2048',
                'nomor_notaris' => 'required',
                'alamat'        => 'required',
                'email'         => 'required',
                'no_hp'         => 'required',

            ]);

            // response error validation
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            }
            if ($request->hasFile('foto')) {
                $name     = $request->file('foto')->getClientOriginalName();
                $filename = time() . '-' . $name;
                $file     = $request->file('foto');
                $file->move(public_path('Image'), $filename);

                NotarisModel::create([
                    'uid'           => Str::uuid(),
                    'nama'          => $request->nama,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'picture'       => $filename,
                    'nomor_notaris' => $request->nomor_notaris,
                    'alamat'        => $request->alamat,
                    'email'         => $request->email,
                    'no_hp'         => $request->no_hp,

                ]);
                Alert::success('Sukses', 'Berhasil Tambah Notaris!');
                return redirect('notaris')->with('success', 'Berhasil tambah data');
            } else {
                NotarisModel::create([
                    'uid'           => Str::uuid(),

                    'nama'          => $request->nama,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'nomor_notaris' => $request->nomor_notaris,
                    'alamat'        => $request->alamat,
                    'email'         => $request->email,
                    'no_hp'         => $request->no_hp,

                ]);
                return redirect('notaris')->with('success', 'Berhasil tambah data');
            }
        }
    }

    public function edit($id)
    {
        $data['notaris'] = NotarisModel::where('uid', $id)->first();
        return view('admin.master_notaris.editnotaris', $data);
    }

    public function update(Request $request, $uid)
    {
        Log::info('Request Data Masuk ke Controller', $request->all());
        $rules = [
            'name'          => 'required',
            'jenis_kelamin' => 'required',
            'nomor_notaris' => 'required',
            'alamat'        => 'required',
            'email'         => 'required',
            'no_hp'         => 'required',
        ];

        if ($request->hasFile('foto')) {
            $rules['foto'] = 'image|mimes:jpeg,png,jpg|max:2048';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::error('Validation Failed', $validator->errors()->toArray());
            return Redirect::back()->withErrors($validator);
        }

        $dataToUpdate = [
            'nama'          => $request->name,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nomor_notaris' => $request->nomor_notaris,
            'alamat'        => $request->alamat,
            'email'         => $request->email,
            'no_hp'         => $request->no_hp,
        ];

        Log::info('Data to Update (Before Foto)', $dataToUpdate);

        if ($request->hasFile('foto')) {
            $name     = $request->file('foto')->getClientOriginalName();
            $filename = time() . '-' . $name;
            $request->file('foto')->move(public_path('Image'), $filename);
            $dataToUpdate['picture'] = $filename;

            Log::info('Foto Uploaded', ['filename' => $filename]);
        }

        Log::info("Updating Notaris with UID: $uid", $dataToUpdate);

        $updated = NotarisModel::where('uid', $uid)->update($dataToUpdate);

        Log::info('Update Status', ['updated' => $updated]);

        return redirect()->back()->with('success', 'Berhasil edit data');
    }

    public function destroy($id)
    {
        NotarisModel::where('uid', $id)->delete();
        return redirect('/notaris')->with('success', 'Berhasil hapus notaris');
    }

    public function getJumlahNotaris(Request $request)
    {

        $query = NotarisModel::get();

        $jumlahNotaris = $query->count();

        return response()->json(['jumlah' => $jumlahNotaris]);
    }
    public function getJumlahLembarKerja(Request $request)
    {

        $query = LembarKerjaModel::get();

        $jumlahLembarKerja = $query->count();

        return response()->json(['jumlah' => $jumlahLembarKerja]);
    }
    public function getJumlahBank(Request $request)
    {

        $query = BankModel::get();

        $jumlahBank = $query->count();

        return response()->json(['jumlah' => $jumlahBank]);
    }
    public function getJumlahSelesai(Request $request)
    {
        try {
            $currentUser = Auth::user();

            if ($currentUser->role_id == 2) {
                // Jika notaris, filter berdasarkan notaris_id
                $uidnotaris = $currentUser->notaris->uid;

                $totalBerkas        = LembarKerjaModel::where('notaris_id', $uidnotaris)->get();
                $totalStatusSelesai = LembarKerjaModel::where('notaris_id', $uidnotaris)
                    ->where('status_selesai', '1')
                    ->get();
            } else {
                // Jika selain notaris, ambil semua data
                $totalBerkas        = LembarKerjaModel::all();
                $totalStatusSelesai = LembarKerjaModel::where('status_selesai', '1')->get();
            }

            return response()->json([
                'jumlah'       => $totalStatusSelesai->count(),
                'jumlahberkas' => $totalBerkas->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getJumlahProses(Request $request)
    {
        try {
            $currentUser = Auth::user();

            if ($currentUser->role_id == 2) {
                // Kalau role notaris, ambil hanya pekerjaan yang sesuai dengan notaris-nya
                $uidnotaris = $currentUser->notaris->uid;
                $query      = LembarKerjaModel::where('notaris_id', $uidnotaris)
                    ->where('status_dikerjakan', '1')
                    ->whereNull('status_selesai');
            } else {
                // Kalau selain notaris, ambil semua pekerjaan dengan status_dikerjakan = 1
                $query = LembarKerjaModel::where('status_dikerjakan', '1')
                    ->whereNull('status_selesai');
            }

            $jumlahProses = $query->count();

            return response()->json(['jumlah' => $jumlahProses]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    // public function getAktivitas(Request $request)
    // {
    //     $currentuser = Auth::user();
    //     $uidnotaris  = Auth::user()->notaris->uid;
    //     // return $uidnotaris;

    //     $data['aktivitas'] = LogAktivitasModel::where('notaris_id', $uidnotaris)
    //         ->get();
    //     // return $aktivitas;

    //     return response()->json($data);
    // }
    public function getAktivitas($uid)
    {
        try {
            $currentuser = Auth::user();
            $uidnotaris  = $currentuser->notaris->uid;

            $aktivitas = LogAktivitasModel::select(
                'log_aktivitas.*',
                'created_notaris.nama as created_notaris_nama',
                'created_bank.nama_bank as created_namabank'
            )
                ->leftJoin('users', 'log_aktivitas.created_by', '=', 'users.uid')
                ->leftJoin('notaris as created_notaris', 'users.id', '=', 'created_notaris.user_id')
                ->leftJoin('bank as created_bank', 'users.id', '=', 'created_bank.user_id')
                ->where('log_aktivitas.notaris_id', $uidnotaris)
                ->orderBy('log_aktivitas.created_at', 'desc')
                ->limit(10)
                ->get();

            return response()->json($aktivitas);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    // public function getAktivitas($uid)
    // {
    //     try {
    //         $currentuser = Auth::user();
    //         $uidnotaris  = $currentuser->notaris->uid;

    //         $aktivitas = LogAktivitasModel::where('notaris_id', $uidnotaris)->get();

    //         return response()->json($aktivitas); // Pastikan return JSON untuk AJAX
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }
    public function getJumlahUangSelesai(Request $request)
    {
        try {
            // Ambil user yang sedang login
            $currentuser = Auth::user();
            $uidnotaris  = $currentuser->notaris->uid; // Ambil UID notaris dari user yang login

            // Hitung total berdasarkan notaris yang sedang login
            $totalFeeSelesai = LembarKerjaModel::where('notaris_id', $uidnotaris)
                ->where('status_selesai', '1')
                ->sum('fee');

            $totalFeeBelum = LembarKerjaModel::where('notaris_id', $uidnotaris)
                ->where(function ($query) {
                    $query->where('status_selesai', '0')
                        ->orWhereNull('status_selesai');
                })
                ->sum('fee');

            $totalFeeSemua = LembarKerjaModel::where('notaris_id', $uidnotaris)->sum('fee');

            return response()->json([
                'total_fee_selesai' => $totalFeeSelesai,
                'total_fee_belum'   => $totalFeeBelum,
                'total_fee_semua'   => $totalFeeSemua,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getGrafikLembarKerja(Request $request)
    {
        try {
            $currentuser = Auth::user();
            $uidnotaris  = $currentuser->notaris->uid;

            // Ambil jumlah selesai per bulan
            $grafikSelesai = LembarKerjaModel::selectRaw("TO_CHAR(created_at, 'YYYY-MM') as bulan, COUNT(*) as total")
                ->where('notaris_id', $uidnotaris)
                ->where('status_selesai', '1')
                ->groupBy('bulan')
                ->orderBy('bulan', 'asc')
                ->get();

            $grafikPending = LembarKerjaModel::selectRaw("TO_CHAR(created_at, 'YYYY-MM') as bulan, COUNT(*) as total")
                ->where('notaris_id', $uidnotaris)
                ->where(function ($query) {
                    $query->where('status_selesai', '0')
                        ->orWhereNull('status_selesai');
                })
                ->groupBy('bulan')
                ->orderBy('bulan', 'asc')
                ->get();

            return response()->json([
                'grafik_selesai' => $grafikSelesai,
                'grafik_pending' => $grafikPending,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getTotalLembarBulan(Request $request)
    {
        try {
            // Ambil user yang sedang login
            $currentuser = Auth::user();
            $uidnotaris  = $currentuser->notaris->uid; // Ambil UID notaris dari user yang login

            // Ambil tahun sekarang
            $tahunSekarang = date('Y');

            // Query menggunakan whereYear() untuk filter tahun sekarang
            $TotalLembarBulan = LembarKerjaModel::selectRaw("TO_CHAR(created_at, 'YYYY-MM') as bulan, COUNT(*) as total")
                ->where('notaris_id', $uidnotaris)
                // ->whereYear('created_at', $tahunSekarang) // Filter berdasarkan tahun sekarang
                // ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
                // ->orderBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
                ->groupBy('bulan')
                ->orderBy('bulan', 'asc')
                ->get();

            return response()->json([
                // 'tahun' => $tahunSekarang,
                'data'  => $TotalLembarBulan,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
