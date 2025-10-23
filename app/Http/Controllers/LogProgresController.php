<?php
namespace App\Http\Controllers;

use App\Models\LembarKerjaModel;
use App\Models\LogAktivitasModel;
use App\Models\LogProgresModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class LogProgresController extends Controller
{
    public function index(Request $request, $uid)
    {
        // return $uid;
        $data['log_progres'] = LogProgresModel::where('lembar_id', $uid)
            ->leftJoin('notaris', 'log_progres.notaris_id', '=', 'notaris.uid')
            ->leftJoin('bank', 'log_progres.bank_id', '=', 'bank.uid')
            ->select(
                'log_progres.*',
                'notaris.nama as notaris_nama',
                'bank.nama_bank as namabank',

            )
            ->get();
        // return $data;
        return view('logproses.log_proses', $data);
    }
    public function show(Request $request, $uid)
    {
        // return $uid;
        $data['log_progres'] = LogProgresModel::where('lembar_id', $uid)
            ->leftJoin('notaris', 'log_progres.notaris_id', '=', 'notaris.uid')
            ->leftJoin('bank', 'log_progres.bank_id', '=', 'bank.uid')
            ->select(
                'log_progres.*',
                'notaris.nama as notaris_nama',
                'bank.nama_bank as namabank',
                'log_progres.keterangan as keterangan_log',
                'log_progres.progres as progres_log',

            )
            ->get();
        // return $data;
        return view('logprogres.log_progres', $data);
    }
    public function tambah_log_progres($id)
    {
        $tambah_log = LembarKerjaModel::where('uid', $id)->first();

        if (! $tambah_log) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Ambil progres terakhir dari log_progres berdasarkan lembar_id
        $lastProgres = DB::table('log_progres')
            ->where('lembar_id', $id)
            ->orderByDesc('id')
            ->value('progres'); // Mengambil satu nilai progres terakhir

        // Jika tidak ada progres sebelumnya, set default ke 0
        $lastProgres = $lastProgres ?? 0;
        return view('logprogres.tambah_log_progres', compact('tambah_log', 'lastProgres'));
    }
    public function log_progres(Request $request)
    {
        $lastProgres = DB::table('log_progres')
            ->where('lembar_id', $request->lembar_id)
            ->orderByDesc('id')
            ->value('progres') ?? 0;

        $validator = Validator::make($request->all(), [
            'bank_id'    => 'required',
            'notaris_id' => 'required',
            'lembar_id'  => 'required',
            'progres'    => [
                'required',
                'numeric',
                'min:' . ($lastProgres + 1),
                'max:100',
                function ($attribute, $value, $fail) use ($lastProgres) {
                    if ($lastProgres >= 100) {
                        $fail('Progres sudah maksimal.');
                    } elseif ($value <= $lastProgres) {
                        $fail('Progres harus lebih besar dari ' . $lastProgres);
                    }
                },
            ],
        ], [
            'progres.max' => 'Progres tidak boleh lebih dari 100%',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Simpan log progres baru
        LogProgresModel::create([
            'uid'        => Str::uuid(),
            'lembar_id'  => $request->lembar_id,
            'notaris_id' => $request->notaris_id,
            'bank_id'    => $request->bank_id,
            'progres'    => $request->progres,
            'keterangan' => $request->keterangan,
        ]);

        // Log aktivitas
        $currentUser = Auth::user();
        LogAktivitasModel::create([
            'uid'               => Str::uuid(),
            'lembar_id'         => $request->lembar_id,
            'notaris_id'        => $request->notaris_id,
            'bank_id'           => $request->bank_id,
            'nama_proses'       => 'Update Progres',
            'created_by'        => $currentUser->uid,
            'tanggal_aktivitas' => Carbon::now(),
        ]);

        Alert::success('Sukses', 'Berhasil Update Progres!');
        return redirect('/lembar_kerja');
    }
}
