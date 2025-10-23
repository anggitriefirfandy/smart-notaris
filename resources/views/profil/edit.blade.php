@extends('layouts.appx')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <a href="{{ url()->previous() }}" class="btn btn-dark btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <h5 class="mb-3">Informasi Akun</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Nama</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label>Password Baru (kosongkan jika tidak diubah)</label>
                                <input type="password" name="password" class="form-control" placeholder="Password baru (opsional)">
                            </div>
                            <div class="col-md-6">
                                <label>Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password">
                            </div>
                        </div>

                        <h5 class="mb-3">Informasi Profil</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Nomor Notaris</label>
                                    <input type="text" name="nomor_notaris" class="form-control" value="{{ old('nomor_notaris', $profil->nomor_notaris ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control">
                                    <option value="1" {{ (old('jenis_kelamin', $profil->jenis_kelamin ?? '') == '1') ? 'selected' : '' }}>Perempuan</option>
                                    <option value="2" {{ (old('jenis_kelamin', $profil->jenis_kelamin ?? '') == '2') ? 'selected' : '' }}>Laki-laki</option>

                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Alamat</label>
                                    <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $profil->alamat ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label>Telepon</label>
                                    <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $profil->telepon ?? '') }}">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label>Foto</label>
                                    <input type="file" name="picture" class="form-control">
                                    @if ($profil->picture)
                                        <img src="{{ asset('Image/' . $profil->picture) }}" alt="Foto Profil" width="120" class="mt-2">
                                    @endif


                                </div>
                            </div>


                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
