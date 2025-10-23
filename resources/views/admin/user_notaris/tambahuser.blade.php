@extends('layouts.appx')

@section('content')

<div class="layout-px-spacing">

    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <a href="{{route('user_notaris.index')}}" class="btn btn-dark btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="{{route('user_notaris.store')}}" method="post">
                        @csrf
                        <div class="row mb-1">
                            <div class="col-lg-6">
                                <label for="form-control">Notaris</label>
                                <select class="select" data-live-search="true" id="ntr" name="notaris" onchange="getnamenotaris()">
                                    <option value="">Pilih salah satu</option>
                                    @foreach($user_notaris as $key => $value)
                                    <option value="{{$value}}"><b>{{$value->nama}}</b> </option>
                                    @endforeach
                                </select>
                                @if($errors->has('notaris'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('notaris') }}
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label for="form-control">Username</label>
                                <input type="text" class="form-control" id="username" name="username">
                                @if($errors->has('username'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('username') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-lg-6">
                                <label for="form-control">Email</label>
                                <input type="email" class="form-control" name="email" autocomplete="off" id="email">
                                @if($errors->has('email'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('email') }}
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label for="form-control">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                                @if($errors->has('password'))
                                <div class="error" style="color: red; display:block;">
                                    {{ $errors->first('password') }}
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm">Simpan</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
