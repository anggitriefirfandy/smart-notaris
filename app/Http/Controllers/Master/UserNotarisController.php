<?php
namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\NotarisModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserNotarisController extends Controller
{
    public function index()
    {
        $data['user_notaris'] = User::where('role_id', 2)->get();
        return view('admin.user_notaris.usernotaris', $data);
    }

    public function create()
    {
        $data['user_notaris'] = NotarisModel::whereNull('user_id')->get();
        return view('admin.user_notaris.tambahuser', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'notaris'  => 'required',
            'username' => 'required',
            'email'    => 'required|unique:users',
            'password' => 'required|min:8',

        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        $ntr  = json_decode($request->notaris);
        $user = User::create([
            'name'     => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'uid'      => $ntr->uid,
            'role_id'  => 2,
        ]);

        NotarisModel::where('uid', $ntr->uid)->update([
            'user_id' => $user['id'],
        ]);
        return redirect('/user_notaris')->with('success', 'Berhasil tambah pengguna');
    }

    public function edit($uid)
    {
        $user = User::where('uid', $uid)->firstOrFail();
        return view('admin.user_notaris.editusernotaris', compact('user'));
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
        $user->role_id = 2;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect('/user_notaris')->with('success', 'Berhasil edit data');
    }

    public function destroy($id)
    {
        $user = User::where('uid', $id)->first();

        if (! $user) {
            return redirect('/user_notaris')->with('error', 'User tidak ditemukan');
        }

        $user->delete();

        return redirect('/user_notaris')->with('success', 'Berhasil hapus user notaris');
    }
}
