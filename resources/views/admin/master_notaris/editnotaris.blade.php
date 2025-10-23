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
                    <a href="{{route('notaris.index')}}" class="btn btn-dark btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="{{route('notaris.update', $notaris['uid'])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-1">

                            <div class="col-lg-4">
                                <label for="form-control">Nama</label>
                                <input type="text" class="form-control" name="name" value="{{$notaris['nama']}}">
                                @if($errors->has('name'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('name') }}
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">nomor notaris</label>
                                <input type="text" class="form-control" name="nomor_notaris" value="{{$notaris['nomor_notaris']}}">
                                @if($errors->has('nomor_notaris'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('nomor_notaris') }}
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">Email</label>
                                <input type="text" class="form-control" name="email" value="{{$notaris['email']}}">
                                @if($errors->has('email'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('email') }}
                                </div>
                                @endif
                            </div>


                        </div>
                        <div class="row mb-1">
                            <div class="col-lg-4">
                                <label for="form-control">Jenis kelamin</label>
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="">Pilih salah satu</option>
                                    @if($notaris['jenis_kelamin'] == 1)
                                    <option value="1" selected>Laki-laki</option>
                                    <option value="2">Perempuan</option>
                                    @else
                                    <option value="1">Laki-laki</option>
                                    <option value="2" selected>Perempuan</option>
                                    @endif
                                </select>
                                @if($errors->has('jenis_kelamin'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('jenis_kelamin') }}
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">alamat</label>
                                <input type="text" class="form-control" name="alamat" value="{{$notaris['alamat']}}">
                                @if($errors->has('alamat'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('alamat') }}
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">No HP</label>
                                <input type="text" class="form-control" name="no_hp" value="{{$notaris['no_hp']}}">
                                @if($errors->has('no_hp'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('no_hp') }}
                                </div>
                                @endif
                            </div>


                        </div>

                        <div class="row mb-4">
                                <div class="col-md-6">
                                    <label>Foto</label>
                                    <input type="file" name="foto" class="form-control">
                                    @if ($notaris->picture)
                                        <img src="{{ asset('Image/' . $notaris->picture) }}" alt="Foto Profil" width="120" class="mt-2">
                                    @endif


                                </div>
                            </div>
                        <div class="row">
                            <div class="col-lg-12 d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
