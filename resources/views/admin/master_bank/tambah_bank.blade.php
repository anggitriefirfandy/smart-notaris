@extends('layouts.appx')

@section('content')

<div class="layout-px-spacing">

    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <a href="{{route('bank.index')}}" class="btn btn-dark btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="{{route('bank.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-1">

                            <div class="col-lg-4">
                                <label for="form-control">Nama Bank</label>
                                <input type="text" class="form-control" name="nama_bank">
                                @if($errors->has('nama_bank'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('nama_bank') }}
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

                        </div>
                        <div class="row mb-1">



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
