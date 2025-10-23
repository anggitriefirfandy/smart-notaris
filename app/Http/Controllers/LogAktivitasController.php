<?php
namespace App\Http\Controllers;

use App\Models\LogAktivitasModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class LogAktivitasController extends Controller
{
    public function index(Request $request, $uid)
    {
        // return $uid;
        $data['log_aktivitas'] = LogAktivitasModel::where('lembar_id', $uid)
            ->leftJoin('notaris', 'log_aktivitas.notaris_id', '=', 'notaris.uid')
            ->leftJoin('bank', 'log_aktivitas.bank_id', '=', 'bank.uid')
            ->select(
                'log_aktivitas.*',
                'notaris.nama as notaris_nama',
                'bank.nama_bank as namabank',

            )
            ->get();
        // return $data;
        return view('log_aktivitas', $data);
    }

    public function show(Request $request, $uid)
    {
        // return $uid;
        $data['log_aktivitas'] = LogAktivitasModel::where('lembar_id', $uid)
            ->leftJoin('notaris', 'log_aktivitas.notaris_id', '=', 'notaris.uid')                // Notaris dari log_aktivitas
            ->leftJoin('bank', 'log_aktivitas.bank_id', '=', 'bank.uid')                         // Bank dari log_aktivitas
            ->leftJoin('users', 'log_aktivitas.created_by', '=', 'users.uid')                    // Menghubungkan created_by ke users
            ->leftJoin('notaris as created_notaris', 'users.id', '=', 'created_notaris.user_id') // Notaris dari created_by
            ->leftJoin('bank as created_bank', 'users.id', '=', 'created_bank.user_id')          // Bank dari created_by
            ->select(
                'log_aktivitas.*',
                'notaris.nama as notaris_nama',                 // Notaris dari log_aktivitas
                'bank.nama_bank as namabank',                   // Bank dari log_aktivitas
                'users.name as created_by',                     // Nama user dari created_by
                'created_notaris.nama as created_notaris_nama', // Notaris dari created_by
                'created_bank.nama_bank as created_namabank'    // Bank dari created_by
            )
            ->get();

        // return $data;
        return view('log_aktivitas', $data);
    }

    public function store(Request $request)
    {

        // Validasi input

        $currentUser = Auth::user();

        // Simpan log aktivitas sesuai format yang diinginkan
        $logaktivitas                    = new LogAktivitasModel();
        $logaktivitas->lembar_id         = Str::uuid();               // Sesuaikan jika ada ID lembar kerja
        $logaktivitas->notaris_id        = $request->notaris ?? null; // Jika ada notaris_id
        $logaktivitas->bank_id           = $currentUser->uid;         // ID user yang login
        $logaktivitas->nama_proses       = 'Mengunduh dokumen';
        $logaktivitas->created_by        = $currentUser->uid;
        $logaktivitas->uid               = Str::uuid();
        $logaktivitas->tanggal_aktivitas = date('Y-m-d');
        $logaktivitas->save();

        return response()->json(['success' => true]);
    }
}
