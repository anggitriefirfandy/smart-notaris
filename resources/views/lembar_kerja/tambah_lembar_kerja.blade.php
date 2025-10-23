@extends('layouts.appx')

@section('content')

<div class="layout-px-spacing">

    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <a href="{{route('lembar_kerja.index')}}" class="btn btn-dark btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="{{route('lembar_kerja.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-1">

                            <div class="col-lg-6">
                                <label for="form-control">Notaris</label>
                                <select class="select2 form-control" data-live-search="true" id="select2-placeholder-single" name="notaris" onchange="getnamenotaris()">
                                    <option value="">Pilih salah satu</option>
                                    @foreach($notaris as $notaris)
                                        <option value="{{$notaris->uid}}"><b>{{$notaris->nama}}</b></option>
                                    @endforeach
                                </select>
                                @if($errors->has('notaris'))
                                    <div class="error" style="color: red; display:block;">
                                        {{ $errors->first('notaris') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-lg-6">
                                <label for="form-control">Nama Pekerjaan</label>
                                <input type="text" class="form-control" name="nama">
                                @if($errors->has('nama'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('nama') }}
                                </div>
                                @endif
                            </div>
                        </div>

                    <div class="row mb-1">






                            <div class="col-lg-6">
                                <label for="form-control">Detail Pekerjaan</label>
                                <textarea class="form-control" name="detail_pekerjaan"></textarea>
                                @if($errors->has('detail_pekerjaan'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('detail_pekerjaan') }}
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label for="form-control">Biaya</label>
                                <input type="number" class="form-control" name="fee">
                                @if($errors->has('fee'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('fee') }}
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-12">
                                <label for="form-control">Keterangan</label>
                                <textarea class="form-control" name="keterangan"></textarea>
                                @if($errors->has('keterangan'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('keterangan') }}
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
