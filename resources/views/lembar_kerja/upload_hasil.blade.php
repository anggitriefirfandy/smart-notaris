<!-- Tampilan upload_berkas.blade.php -->

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
                    <form id="uploadHasilForm" action="{{route('hasil_kerja.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-1">

                            <div class="col-lg-4">
                                <label for="form-control">ID lembar kerja </label>
                                <input type="text" class="form-control" name="lembar_id" value="{{ $hasil_kerja->nama }}" readonly>
                                <input type="hidden" name="lembar_id" value="{{ $hasil_kerja->uid }}">
                                    @if($errors->has('lembar_id'))
                                    <div class="error" style="color: red; display:block;">
                                        {{ $errors->first('lembar_id') }}
                                    </div>
                                    @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">Notaris ID</label>
                                <input type="text" class="form-control" name="notaris_id" value="{{ $hasil_kerja->notaris->nama }}" readonly>
                                <input type="hidden" name="notaris_id" value="{{ $hasil_kerja->notaris_id }}">
                                    @if($errors->has('notaris_id'))
                                    <div class="error" style="color: red; display:block;">
                                        {{ $errors->first('notaris_id') }}
                                    </div>
                                    @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">Bank ID</label>
                                <input type="text" class="form-control" name="bank_id" value="{{ $hasil_kerja->bank->nama_bank }}" readonly>
                                <input type="hidden" name="bank_id" value="{{ $hasil_kerja->bank_id }}">
                                    @if($errors->has('bank_id'))
                                    <div class="error" style="color: red; display:block;">
                                        {{ $errors->first('bank_id') }}
                                    </div>
                                    @endif
                            </div>
                            <div class="col-lg-4">
                                <label for="form-control">Unggah Hasil Kerja</label>
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
                    <div class="progress mt-3" style="height: 25px; display: none;">
                        <div id="hasilUploadProgress" class="progress-bar progress-bar-striped progress-bar-animated"
                            role="progressbar" style="width: 0%">0%</div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<script>
document.getElementById('uploadHasilForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let form = e.target;
    let formData = new FormData(form);
    let progressBar = document.getElementById('hasilUploadProgress').parentElement;
    let bar = document.getElementById('hasilUploadProgress');

    // Validasi file input
    const fileInput = form.querySelector('input[name="uploaded_file"]');
    if (fileInput.files.length === 0) {
        Swal.fire({
            title: 'Oops!',
            text: 'Silakan pilih file terlebih dahulu.',
            icon: 'warning'
        });
        return;
    }

    progressBar.style.display = 'block';

    let xhr = new XMLHttpRequest();
    xhr.open('POST', "{{ route('hasil_kerja.store') }}", true);
    xhr.setRequestHeader('X-CSRF-TOKEN', "{{ csrf_token() }}");

    xhr.upload.onprogress = function(e) {
        if (e.lengthComputable) {
            let percent = Math.round((e.loaded / e.total) * 100);
            bar.style.width = percent + '%';
            bar.innerText = percent + '%';
        }
    };

    xhr.onload = function() {
        if (xhr.status === 200) {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Hasil kerja berhasil diunggah!',
                icon: 'success'
            }).then(() => {
                window.location.href = "/lembar_kerja";
            });
        } else {
            Swal.fire({
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat upload.',
                icon: 'error'
            });
        }
    };

    xhr.onerror = function() {
        Swal.fire({
            title: 'Error!',
            text: 'Upload gagal, coba lagi.',
            icon: 'error'
        });
    };

    xhr.send(formData);
});
</script>

@endsection
