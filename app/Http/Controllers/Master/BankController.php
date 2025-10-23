<?php
namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\BankModel;
use App\Models\LembarKerjaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BankController extends Controller
{
    public function index()
    {
        $data['bank'] = BankModel::get();
        return view('admin.master_bank.bank', $data);
    }

    public function create()
    {
        return view('admin.master_bank.tambah_bank');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_bank' => 'required',

            'no_hp'     => 'required',

        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        BankModel::create([
            'uid'       => Str::uuid(),
            'nama_bank' => $request->nama_bank,
            'no_hp'     => $request->no_hp,

        ]);

        return redirect('/bank')->with('success', 'Berhasil tambah bank');
    }
    public function edit($id)
    {
        $data['bank'] = BankModel::where('uid', $id)->first();
        return view('admin.master_bank.editbank', $data);
    }
    public function update(Request $request, $id)
    {
        $rules = [
            'nama_bank' => 'required',
            'no_hp'     => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $dataToUpdate = [
            'nama_bank' => $request->nama_bank,
            'no_hp'     => $request->no_hp,
        ];

        BankModel::where('uid', $id)->update($dataToUpdate);

        return redirect('/bank')->with('success', 'Berhasil edit data');
    }
    public function destroy($id)
    {
        $bank = BankModel::where('uid', $id)->first();

        if (! $bank) {
            return redirect('/bank')->with('error', 'Bank tidak ditemukan');
        }

        $bank->delete();

        return redirect('/bank')->with('success', 'Berhasil hapus bank');
    }

    public function getJumlahUangSelesaiBank(Request $request)
    {
        try {

            // Hitung total berdasarkan notaris yang sedang login
            $totalFeeSelesai = LembarKerjaModel::where('status_selesai', '1')
                ->sum('fee');

            $totalFeeBelum = LembarKerjaModel::where(function ($query) {
                $query->where('status_selesai', '0')
                    ->orWhereNull('status_selesai');
            })
                ->sum('fee');

            $totalFeeSemua = LembarKerjaModel::sum('fee');

            return response()->json([
                'total_fee_selesai' => $totalFeeSelesai,
                'total_fee_belum'   => $totalFeeBelum,
                'total_fee_semua'   => $totalFeeSemua,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getPieGrafik(Request $request)
    {
        try {

            // Kalau selain notaris, ambil semua pekerjaan dengan status_dikerjakan = 1
            $belumditerima   = LembarKerjaModel::where('status_diterima', '0');
            $belumdikerjakan = LembarKerjaModel::where('status_diterima', '1')
                ->whereNull('status_dikerjakan');
            $semua  = LembarKerjaModel::get();
            $proses = LembarKerjaModel::where('status_dikerjakan', '1')
                ->whereNull('status_selesai');
            $selesai = LembarKerjaModel::where('status_selesai', '1')
                ->where('status_dikerjakan', '1');

            return response()->json([

                'semua'            => $semua->count(),
                'belumdikerjakan'  => $belumdikerjakan->count(),
                'prosespengerjaan' => $proses->count(),
                'selesai'          => $selesai->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
