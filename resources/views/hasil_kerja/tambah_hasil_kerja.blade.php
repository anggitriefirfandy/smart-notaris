@extends('layouts.appx')

@section('content')

<div class="layout-px-spacing">

    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <a href="{{route('hasil_kerja.index')}}" class="btn btn-dark btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="{{route('hasil_kerja.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-1">

                            <div class="col-lg-12">
                                <label for="form-control">Notaris</label>
                                <select class="selectpicker" data-live-search="true" id="ntr" name="notaris" onchange="getnamenotaris()">
                                    <option value="">Pilih salah satu</option>
                                    @foreach($notaris as $notaris)
                                        <option value="{{$notaris->id}}"><b>{{$notaris->nama}}</b></option>
                                    @endforeach
                                </select>
                                @if($errors->has('notaris'))
                                    <div class="error" style="color: red; display:block;">
                                        {{ $errors->first('notaris') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-12">
                                <label for="form-control">Lembar Kerja</label>
                                <select class="selectpicker" data-live-search="true" id="ntr" name="lembar_kerja" onchange="getnamenotaris()">
                                    <option value="">Pilih salah satu</option>
                                    @foreach($lembar_kerja as $hasil)
                                        <option value="{{$hasil->id}}"><b>{{$hasil->nama}}</b></option>
                                    @endforeach
                                </select>
                                @if($errors->has('lembar_kerja'))
                                    <div class="error" style="color: red; display:block;">
                                        {{ $errors->first('lembar_kerja') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">Dokumen</label>
                                <input type="text" class="form-control" name="dokumen">
                                @if($errors->has('dokumen'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('dokumen') }}
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">Status</label>
                                <input type="text" class="form-control" name="status">
                                @if($errors->has('status'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('status') }}
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">Status Dokumen</label>
                                <input type="text" class="form-control" name="status_doc">
                                @if($errors->has('status_doc'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('status_doc') }}
                                </div>
                                @endif
                            </div>



                            <!-- <div class="col-lg-12">
                                <label for="form-control">Merchant</label>
                                <input type="text" class="form-control" name="merchant_id">
                                @if($errors->has('merchant_id'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('merchant_id') }}
                                </div>
                                @endif
                            </div> -->

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
