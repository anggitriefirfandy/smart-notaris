@extends('layouts.appx')

@section('content')

<div class="layout-px-spacing">

    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <!-- <a href="{{route('lembar_kerja.create')}}" class="btn btn-primary btn-sm">Tambah</a> -->


                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-hover" id="default-ordering">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Cabang</th>
                                        <th>No Order</th>
                                        <th>Pekerjaan</th>
                                        <th>Lembar Kerja</th>
                                        <th>Tanggal Unggah</th>
                                        <th>Status</th>
                                        <th>nama dokumen</th>
                                        <th>Unduh</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayat as $key => $value)
                                    <tr>
                                        <td width="1%">{{$key + 1}}</td>
                                        <td>{{$value->cabang->name}}</td>
                                        <td>{{$value->no_pesanan}}</td>
                                        <td>{{$value->jenisPekerjaan->pekerjaan}}</td>
                                        <td>{{$value->nasabah}}</td>
                                        <td>{{$value->created_at}}</td>
                                        <!-- <td>{{$value->status}}</td> -->
                                        <td>
                                        @if($value->status_riwdoc == 0)
                                            <span class="badge badge-info">Menunggu diterima</span>
                                            @elseif($value->status_riwdoc == 1)
                                            <span class="badge badge-success">Sudah Di terima</span>
                                            @else
                                            <span class="badge badge-danger">Belum Di terima</span>
                                            @endif
                                        </td>
                                        <td>{{$value->dokumen}}</td>

                                        <td class="text-center" style="display: flex; justify-content: center;">
                                            <a href="{{ route('lembar_kerja.edit', $value->uid) }}" class="btn btn-warning mb-1 mr-1 rounded-circle" data-toggle="tooltip" title='Update'><i class="bx bx-edit bx-sm"></i></a>

                                            <form action="{{ route('lembar_kerja.destroy', $value->uid) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger mb-1 mr-1 rounded-circle show_confirm" data-toggle="tooltip" title='Delete' type="submit"><i class="bx bx-trash bx-sm"></i></button>
                                            </form>

                                            <a href="{{ url('/'. $value->dokumen) }}" class="btn btn-success mb-1 mr-1 rounded-circle" data-toggle="tooltip" title='Download Dokumen'><i class="bx bx-download bx-sm"></i></a>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aksi
                                            </button>
                                            <div class="dropdown-menu">
                                                @if($value->status_riwdoc == 0)
                                                <a onclick="changestatusriwdoc('{{$value->uid_riwdoc}}', 1)" class="dropdown-item">Di Terima</a>
                                                <a onclick="changestatusriwdoc('{{$value->uid_riwdoc}}', 2)" class="dropdown-item">Tidak di terima</a>
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
        function changestatusriwdoc(uid_riwdoc, status_riwdoc) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "/changestatusriwdoc/" + uid_riwdoc,
                method: 'post',
                data: {
                    status: status_riwdoc
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
