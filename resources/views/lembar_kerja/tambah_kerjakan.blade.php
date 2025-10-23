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
                    <form action="{{route('kerjakan')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-1">

                            <div class="col-lg-4">
                                <label for="form-control">ID lembar kerja </label>
                                <input type="text" class="form-control" name="lembar_id" value="{{ $kerjakan->nama }}" readonly>
                                <input type="hidden" name="lembar_id" value="{{ $kerjakan->uid }}" readonly>
                                    @if($errors->has('lembar_id'))
                                    <div class="error" style="color: red; display:block;">
                                        {{ $errors->first('lembar_id') }}
                                    </div>
                                    @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">ID Notaris </label>
                                <input type="text" class="form-control" name="notaris_id" value="{{ $kerjakan->notaris->nama }}" readonly>
                                <input type="hidden"  name="notaris_id" value="{{ $kerjakan->notaris_id }}">
                                    @if($errors->has('notaris_id'))
                                    <div class="error" style="color: red; display:block;">
                                        {{ $errors->first('notaris_id') }}
                                    </div>
                                    @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">ID Bank </label>
                                <input type="text" class="form-control" name="bank_id" value="{{ $kerjakan->bank->nama_bank ?? '-' }}" readonly>
                                <input type="hidden" name="bank_id" value="{{ $kerjakan->bank_id }}">
                                    @if($errors->has('bank_id'))
                                    <div class="error" style="color: red; display:block;">
                                        {{ $errors->first('bank_id') }}
                                    </div>
                                    @endif
                            </div>
                            <!-- <div class="col-lg-4">
                                <label for="form-control">User ID</label>
                                <input type="text" class="form-control" name="user_id" value="{{ $kerjakan->user_id }}" readonly>
                                    @if($errors->has('user_id'))
                                    <div class="error" style="color: red; display:block;">
                                        {{ $errors->first('user_id') }}
                                    </div>
                                    @endif
                            </div> -->
                            <div class="col-lg-4">
                                <label for="form-control">due date</label>
                                <input type="datetime-local" class="form-control" name="waktu_proses">
                                @if($errors->has('waktu_proses'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('waktu_proses') }}
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">Unggah Covernote</label>
                                <input type="file" class="form-control" name="uploaded_file">
                                @if($errors->has('uploaded_file'))
                                    <div class="error" style="color: red; display:block;">
                                        {{ $errors->first('uploaded_file') }}
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
                <input type="text" class="form-control" name="kerjakan" value="{{ $kerjakan->id }}" readonly>
            </div>
            <div class="col-lg-4">
                <label for="form-control">User ID</label>
                <input type="text" class="form-control" name="user_id" value="{{ $kerjakan->user_id }}" readonly>
            </div> -->
@endsection
