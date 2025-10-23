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
                    <form action="{{route('log_progres')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-1">

                            <div class="col-lg-4">
                                <label for="form-control">ID lembar kerja </label>
                                <input type="text" class="form-control" name="lembar_id" value="{{ $tambah_log->nama }}" readonly>
                                <input type="hidden"  name="lembar_id" value="{{ $tambah_log->uid }}">
                                    @if($errors->has('lembar_id'))
                                    <div class="error" style="color: red; display:block;">
                                        {{ $errors->first('lembar_id') }}
                                    </div>
                                    @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">ID Notaris </label>
                                <input type="text" class="form-control" name="notaris_id" value="{{ $tambah_log->notaris->nama }}" readonly>
                                <input type="hidden" name="notaris_id" value="{{ $tambah_log->notaris_id }}" >
                                    @if($errors->has('notaris_id'))
                                    <div class="error" style="color: red; display:block;">
                                        {{ $errors->first('notaris_id') }}
                                    </div>
                                    @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">ID Bank </label>
                                <input type="text" class="form-control"  value="{{ $tambah_log->bank->nama_bank ?? '-'}}" readonly>
                                <input type="hidden"  name="bank_id" value="{{ $tambah_log->bank_id }}">
                                    @if($errors->has('bank_id'))
                                    <div class="error" style="color: red; display:block;">
                                        {{ $errors->first('bank_id') }}
                                    </div>
                                    @endif
                            </div>

                            <div class="col-lg-4">
                                <label for="form-control">Progres</label>
                                <input type="number" class="form-control" name="progres" min="{{ $lastProgres }}" max="100" value="{{ old('progres', $lastProgres) }}">
                                @if($errors->has('progres'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('progres') }}
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
