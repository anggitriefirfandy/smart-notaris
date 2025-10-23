@extends('layouts.appx')

@section('content')

<div class="layout-px-spacing">

    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-hover" id="default-ordering">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pekerjaan</th>
                                        <th>Cabang</th>
                                        <th>Lembar Kerja</th>
                                        <th>Nasabah</th>
                                        <th>Tanggal Unggah</th>
                                        <th>status</th>
                                        <th>Unduh</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($hasil_kerja as $key => $value)
                                    <tr>
                                        <td width="1%">{{$key + 1}}</td>
                                        <td>{{$value->jenisPekerjaan->pekerjaan}}</td>
                                        <td>{{$value->cabang->name}}</td>
                                        <td>{{$value->notaris->nama}}</td>
                                        <td>{{$value->nasabah}}</td>
                                        <td>{{$value->created_at}}</td>
                                        <td>
                                        @if($value->status_kerja == 0)
                                            <span class="badge badge-info">Menunggu Pengecekan</span>
                                            @elseif($value->status_kerja == 1)
                                            <span class="badge badge-success">Sudah Di terima</span>
                                            @else
                                            <span class="badge badge-danger">Belum Di terima</span>
                                            @endif
                                        </td>
                                        <td class="text-center" style="display: flex; justify-content: center;">
                                        <a href="{{ url('/'. $value->dokumen) }}" class="btn btn-success mb-1 mr-1 " data-toggle="tooltip" title='Download Hasil Kerja'>Unduh Berkas</a>
                                        </td>

                                        <td>
                                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aksi
                                            </button>
                                            <div class="dropdown-menu">
                                                @if($value->status == 0)
                                                <a onclick="changestatus('{{$value->uid_kerja}}', 1)" class="dropdown-item">Di Terima</a>
                                                <a onclick="changestatus('{{$value->uid_kerja}}', 2)" class="dropdown-item">Tidak di terima</a>
                                                @endif
                                            </div>
                                        </td>
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
    <script>
        function changestatus(uid, status) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "/changestatus/" + uid,
                method: 'post',
                data: {
                    status: status
                },
                success: function(result) {
                    // Swal.fire(
                    //     result.msg,
                    //     'success'
                    // )
                    Swal.fire({
                        icon: 'success',
                        title: 'Informasi',
                        text: result.msg,
                    })
                    location.reload();
                    // console.log(result.data)
                },

            })
        }
    </script>

</div>
@endsection
