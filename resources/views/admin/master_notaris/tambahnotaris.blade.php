@extends('layouts.appx')

@section('content')

<div class="layout-px-spacing">

    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <a href="{{route('notaris.index')}}" class="btn btn-dark btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="{{route('notaris.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-1">

                            <div class="col-lg-4">
                                <label for="form-control">Nama</label>
                                <input type="text" class="form-control" name="nama">
                                @if($errors->has('nama'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('nama') }}
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">Jenis kelamin</label>
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="">Pilih salah satu</option>
                                    <option value="1">Laki-laki</option>
                                    <option value="2">Perempuan</option>
                                </select>
                                @if($errors->has('jenis_kelamin'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('jenis_kelamin') }}
                                </div>
                                @endif
                            </div><div class="col-lg-4">
                                <label for="form-control">nomor notaris</label>
                                <input type="text" class="form-control" name="nomor_notaris">
                                @if($errors->has('nomor_notaris'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('nomor_notaris') }}
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">Alamat</label>
                                <input type="text" class="form-control" name="alamat">
                                @if($errors->has('alamat'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('alamat') }}
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">email</label>
                                <input type="text" class="form-control" name="email">
                                @if($errors->has('email'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('email') }}
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">no hp</label>
                                <input type="text" class="form-control" name="no_hp">
                                @if($errors->has('no_hp'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('no_hp') }}
                                </div>
                                @endif
                            </div>
                            <!-- <div class="col-lg-4">
                                <label for="form-control">Telepon</label>
                                <input type="text" class="form-control" name="telepon">
                                @if($errors->has('telepon'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('telepon') }}
                                </div>
                                @endif
                            </div> -->
                            <!-- <div class="col-lg-4">
                                <label for="form-control">Fax</label>
                                <input type="text" class="form-control" name="fax">
                                @if($errors->has('fax'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('fax') }}
                                </div>
                                @endif
                            </div> -->

                            <!-- <div class="col-lg-4">
                                <label for="form-control">Lock</label>
                                <input type="text" class="form-control" name="lock">
                                @if($errors->has('lock'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('lock') }}
                                </div>
                                @endif
                            </div> -->
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label>Foto</label>
                                <input type="file" name="foto" class="form-control" onchange="previewFoto(this)">

                                <img id="preview-image" src="#" alt="Preview" class="mt-2" style="display:none; max-height: 150px;">
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
<script>
    function previewFoto(input) {
        const preview = document.getElementById('preview-image');
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }
</script>
@endsection
