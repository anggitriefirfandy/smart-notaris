<?php
namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\BankModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserBankController extends Controller
{
    public function index()
    {
        $data['user_bank'] = User::where('role_id', 1)->get();
        return view('admin.user_bank.userbank', $data);
    }

    public function create()
    {
        $data['user_bank'] = BankModel::whereNull('user_id')->get();
        return view('admin.user_bank.tambah_userbank', $data);
    }

    public function store(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'bank'     => 'required',
            'username' => 'required',
            'email'    => 'required|unique:users',
            'password' => 'required|min:8',

        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        $ntr = json_decode($request->bank);
        // dd($ntr);

        $user = User::create([
            'name'     => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'uid'      => $ntr->uid,
            'role_id'  => 1,
        ]);
        // return $user;

        BankModel::where('uid', $ntr->uid)->update([
            'user_id' => $user['id'],
        ]);
        return redirect('/user_bank')->with('success', 'Berhasil tambah pengguna');
    }
    public function edit($uid)
    {
        $user = User::where('uid', $uid)->firstOrFail();
        return view('admin.user_bank.edituserbank', compact('user'));
    }
    public function destroy($id)
    {
        $user = User::where('uid', $id)->first();

        if (! $user) {
            return redirect('/user_bank')->with('error', 'User tidak ditemukan');
        }

        $user->delete();

        return redirect('/user_bank')->with('success', 'Berhasil hapus user bank');
    }
    public function update(Request $request, $uid)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $uid,

        ]);

        $user          = User::findOrFail($uid);
        $user->name    = $request->name;
        $user->email   = $request->email;
        $user->role_id = 1;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect('/user_bank')->with('success', 'Berhasil edit data');
    }
}
