@extends('layouts.appx')

@section('content')

<div class="layout-px-spacing">

    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a style="" href="{{route('lembar_kerja.index')}}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-hover" id="default-ordering">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <!-- <th>ID Lembar</th> -->
                                        <th>ID Notaris</th>
                                        <th>ID Bank</th>
                                        <th>Nama Proses</th>
                                        <th>Created By</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($log_aktivitas as $key => $value)
                                    <tr>
                                        <td width="1%">{{$key + 1}}</td>
                                        <td>{{$value->notaris_nama}}</td> <!-- Notaris dari log_aktivitas -->
                                        <td>{{$value->namabank}}</td> <!-- Bank dari log_aktivitas -->
                                        <td>{{$value->nama_proses}}</td>

                                        <!-- Kolom created_by: Prioritaskan notaris, jika tidak ada, gunakan bank -->
                                        <td>
                                            {{ $value->created_notaris_nama ?? $value->created_namabank ?? '-' }}
                                        </td>

                                        <td>{{\Carbon\Carbon::parse($value->tanggal_aktivitas)->format('d-M-Y')}}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
