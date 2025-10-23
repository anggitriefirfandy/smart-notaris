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
                <form action="{{route('lembar_kerja.update', $lembar_kerja['uid'])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-1">
                            <!-- <div class="col-lg-12">
                                <label for="form-control">Notaris</label>
                                <select class="select2 form-control" data-live-search="true" id="select2-placeholder-single" name="notaris" onchange="getnamenotaris()" value="{{$lembar_kerja['notaris']}}">
                                    <option value="">Pilih salah satu</option>

                                </select>
                                @if($errors->has('notaris'))
                                    <div class="error" style="color: red; display:block;">
                                        {{ $errors->first('notaris') }}
                                    </div>
                                @endif
                            </div> -->
                        </div>

                    <div class="row mb-1">


                        <div class="col-lg-4">
                                <label for="form-control">Nama Pekerjaan</label>
                                <input type="text" class="form-control" name="nama" value="{{$lembar_kerja['nama']}}">
                                @if($errors->has('nama'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('nama') }}
                                </div>
                                @endif
                            </div>




                            <div class="col-lg-12">
                                <label for="form-control">Detail Pekerjaan</label>
                                <textarea class="form-control" name="detail_pekerjaan" value="{{$lembar_kerja['detail_pekerjaan']}}"></textarea>
                                @if($errors->has('detail_pekerjaan'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('detail_pekerjaan') }}
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">Fee</label>
                                <input type="number" class="form-control" name="fee" value="{{$lembar_kerja['fee']}}">
                                @if($errors->has('fee'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('fee') }}
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-12">
                                <label for="form-control">Keterangan</label>
                                <textarea class="form-control" name="keterangan" value="{{$lembar_kerja['keterangan']}}"></textarea>
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


<!-- <div class="col-lg-4">
                <label for="form-control">ID lembar kerja </label>
                <input type="text" class="form-control" name="lembar$lembar_kerja" value="{{ $lembar_kerja->id }}" readonly>
            </div>
            <div class="col-lg-4">
                <label for="form-control">User ID</label>
                <input type="text" class="form-control" name="user_id" value="{{ $lembar_kerja->user_id }}" readonly>
            </div> -->
@endsection
