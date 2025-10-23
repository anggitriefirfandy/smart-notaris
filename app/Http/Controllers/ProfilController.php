<?php
namespace App\Http\Controllers;

use App\Models\NotarisModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function edit()
    {
        $user   = Auth::user();
        $profil = NotarisModel::where('user_id', $user->id)->first(); // tabel profil punya foreign key ke users
        return view('profil.edit', compact('user', 'profil'));
    }

    public function update(Request $request)
    {
        // return response()->json($request->all());
        $request->validate([
            'name'          => 'required|string',
            'email'         => 'required|email',
            'alamat'        => 'nullable|string',
            'telepon'       => 'nullable|string',
            'password'      => 'nullable|min:6|confirmed',
            "nomor_notaris" => 'nullable|string',
            "jenis_kelamin" => 'nullable|string',
            'picture'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        // Update user table
        $user->name  = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        // Update profil table
        $profil                = NotarisModel::firstOrCreate(['user_id' => $user->id]);
        $profil->alamat        = $request->alamat;
        $profil->nomor_notaris = $request->nomor_notaris;
        $profil->jenis_kelamin = $request->jenis_kelamin;
        $profil->telepon       = $request->telepon;

        if ($request->hasFile('picture')) {
            // Hapus file lama jika ada
            if ($profil->picture && file_exists(public_path('Image/' . $profil->picture))) {
                unlink(public_path('Image/' . $profil->picture));
            }

            $file     = $request->file('picture');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('Image'), $filename);
            $profil->picture = $filename;
        }

        $profil->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
