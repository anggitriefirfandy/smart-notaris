@extends('layouts.appx')

@section('content')

<div class="layout-px-spacing">

    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{route('bank.create')}}" class="btn btn-primary btn-sm">Tambah</a>

                    <!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modelId">
                        Import
                    </button> -->

                    <!-- Modal -->
                    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">

                    </div>
                    <!-- endmodal -->
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-hover" id="default-ordering">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pegawai</th>
                                        <th>no_hp</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bank as $key => $value)
                                    <tr>
                                        <td width="1%">{{$key + 1}}</td>

                                        <td>{{$value->nama_bank}}</td>

                                        <td>{{$value->no_hp}}</td>

                                        <td class="text-center" style="display: flex; justify-content: left;">
                                            <a style="margin-right: 10px" href="{{ route('bank.edit', $value->uid) }}" class="btn btn-warning mb-1 mr-1 " data-toggle="tooltip" title='Update'><i class="fa-solid fa-pen"></i></a>
                                            <form action="{{ route('bank.destroy', $value->uid) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger mb-1 mr-1 show_confirm" data-toggle="tooltip" title='Delete' type="submit"><i class="fa-solid fa-trash"></i></button>
                                            </form>
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

</div>
<script>
      // Saat tombol hapus ditekan
      document.querySelectorAll('.show_confirm').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // cegah submit form langsung

            const form = this.closest("form");

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // kirim form kalau dikonfirmasi
                }
            });
        });
    });

</script>

@endsection
