@extends('layouts.appx')
<head>
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> -->
</head>
@section('content')
@inject('carbon', 'Carbon\Carbon')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="layout-px-spacing">

    <div class="row layout-top-spacing">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-start align-items-center gap-2">
                @IsBank
                <a href="{{route('lembar_kerja.create')}}" class="btn btn-primary btn-sm">Tambah</a>
                @endIsBank
                <!-- <form action="{{ route('lembar_kerja.cutoff') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Cutoff</button>
                </form> -->
                </div>
                <div class="card-body">
                    <div class="row">
                        <div style="max-height: 1000px; overflow-y: auto;" class="col-lg-12">
                            <table class="table table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Dikerjakan Oleh</th>
                                        <th>Nama Pekerjaan</th>
                                        <th>detail pekerjaan</th>
                                        <th>Keterangan</th>
                                        <th>Due Date</th>
                                        <th>Progres</th>
                                        <th>Fee</th>
                                        <th>Dokumen</th>
                                        <th>Covernote</th>
                                        <th>Hasil</th>
                                        <th>Tanggal </th>
                                        <th>Status</th>
                                        <th width="300">Aksi</th>
                                        <!-- <th width="300">Log</th> -->
                                        <!-- <th width="300">Download</th> -->
                                        @IsNotaris
                                        <th>Kerjakan</th>
                                        @endIsNotaris
                                        <!-- <th width="300">Upload</th> -->

                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($lembar_kerja as $key => $value)
                                    <tr>

                                        <td width="1%">{{$key + 1}}</td>
                                        <td>{{$value->notaris_nama}}</td> <!-- Akses nama dari relasi notaris -->
                                        <td>{{$value->nama}}</td>
                                        <td>{{$value->detail_pekerjaan}}</td>
                                        <td>{{$value->keterangan}}</td>
                                        <td id="countdown-{{ $value->uid }}">
                                            {{ $value->waktu_proses ? \Carbon\Carbon::parse($value->waktu_proses)->format('Y-m-d H:i:s') : 'Belum Diset' }}
                                        </td>
                                        <td>{{ $value->progres }}%</td>
                                        <td>{{ $value->fee }}</td>
                                        <td>
                                            @if($value->dokumen)
                                                <span class="badge badge-success">Ada</span>
                                            @else
                                                <span class="badge badge-secondary">Kosong</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($value->covernote)
                                                <span class="badge badge-success">Ada</span>
                                            @else
                                                <span class="badge badge-secondary">Kosong</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($value->hasil)
                                                <span class="badge badge-success">Ada</span>
                                            @else
                                                <span class="badge badge-secondary">Kosong</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($value->created_at)->format('d-M-Y')}}
                                        </td>
                                        <td>
                                            @if($value->status_diterima == 0)
                                                <span class="badge badge-info">File Belum Di Terima</span>
                                            @elseif(in_array($value->status_diterima, [1, 2]))
                                                @if($value->status_dikerjakan == 0)
                                                    <span class="badge badge-info">File Belum Di Proses</span>
                                                @elseif(in_array($value->status_dikerjakan, [1, 2]))
                                                    @if($value->status_selesai == 0)
                                                        <span class="badge badge-info">Pekerjaan Belum Selesai</span>
                                                    @elseif($value->status_selesai == 1)
                                                        <span class="badge badge-success">Pekerjaan Selesai</span>
                                                    @else
                                                        <span class="badge badge-danger">Pekerjaan Belum Selesai</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                        <td>

                                    <div class="dropdown dropend my-1">
                                    <button type="button" class="btn btn-primary dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <div class="dropdown-menu"
                                    style=" overflow-y: auto;">
                                        <a href="/log-aktivitas/{{$value->uid}}" class="dropdown-item">Log Aktivitas</a>
                                        <a href="/show-log-progres/{{$value->uid}}" class="dropdown-item">Log Progres</a>
                                        <hr style="border: 1px solid blue; margin: 0px">
                                                @if ($value->dokumen)
                                                    <a href="/download_dokumen?uuidfile={{ $value->uid }}&notaris_id={{ $value->notaris_id }}&bank_id={{ $value->bank_id }}&lembar_id={{ $value->uuid }}"
                                                    target="_blank"
                                                    class="dropdown-item"
                                                    >
                                                        Download Dokumen
                                                    </a>
                                                @endif
                                                @if ($value->covernote)
                                                    <a href="/download_covernote?uuidfile={{ $value->uid }}&notaris_id={{ $value->notaris_id }}&bank_id={{ $value->bank_id }}&lembar_id={{ $value->uuid }}"
                                                    target="_blank"
                                                    class="dropdown-item"
                                                    >
                                                        Download Covernote
                                                    </a>
                                                    @endif
                                                    @if ($value->hasil)
                                                    <a href="/download_hasil?uuidfile={{ $value->uid }}&notaris_id={{ $value->notaris_id }}&bank_id={{ $value->bank_id }}&lembar_id={{ $value->uuid }}"
                                                    target="_blank"
                                                    class="dropdown-item"
                                                    >
                                                        Download Hasil
                                                    </a>
                                                @endif
                                        <hr style="border: 1px solid blue; margin: 0px">
                                        @IsBank
                                                <a href="{{ route('lembar_kerja.edit', $value->uid) }}" class="dropdown-item">Edit Lembar</a>
                                            @if($value->status_selesai == 0)
                                                <a onclick="changestatusselesai('{{$value->uid}}', 1)" class="dropdown-item">Selesai</a>
                                                <a onclick="changestatusselesai('{{$value->uid}}', 2)" class="dropdown-item">Belum Selesai</a>
                                            @endif
                                            <a href="/upload_dokumen/{{$value->uid}}" class="dropdown-item">Upload Dokumen</a>
                                        @endIsBank
                                        @IsNotaris
                                            @if($value->status_diterima == 0 )
                                                <a onclick="changestatus('{{$value->uid}}', 1)" class="dropdown-item">Di Terima</a>
                                                <a onclick="changestatus('{{$value->uid}}', 2)" class="dropdown-item">Tidak Di Terima</a>
                                            @endif
                                                <a href="/tambah_log_progres/{{$value->uid}}" class="dropdown-item">update progres</a>
                                            @if($value->status_dikerjakan == 1)
                                                <a href="/upload_hasil/{{$value->uid}}" class="dropdown-item">Upload Hasil Kerja</a>
                                            @endif
                                        @endIsNotaris
                                        </div>
                                    </div>
                                    </td>

                                    <!-- <td>
                                        <div class="dropdown dropend my-1">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Log
                                            </button>
                                            <div class="dropdown-menu"
                                            style=" overflow-y: auto;">


                                                <a href="/log-aktivitas/{{$value->uid}}" class="dropdown-item">Log Aktivitas</a>
                                                <a href="/show-log-progres/{{$value->uid}}" class="dropdown-item">Log Progres</a>
                                            </div>
                                        </div>
                                    </td> -->
                                    <!-- <td>
                                        <div class="dropdown dropend my-1">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Download
                                            </button>
                                            <div class="dropdown-menu"
                                            style=" overflow-y: auto;">
                                                @if ($value->dokumen)
                                                <a href="/download_dokumen?uuidfile={{ $value->uid }}&notaris_id={{ $value->notaris_id }}&bank_id={{ $value->bank_id }}&lembar_id={{ $value->uuid }}"
                                                    target="_blank"
                                                    class="dropdown-item"
                                                    >
                                                        Download Dokumen
                                                    </a>
                                                @endif
                                                @if ($value->covernote)
                                                    <a href="/download_covernote?uuidfile={{ $value->uid }}&notaris_id={{ $value->notaris_id }}&bank_id={{ $value->bank_id }}&lembar_id={{ $value->uuid }}"
                                                    target="_blank"
                                                    class="dropdown-item"
                                                    >
                                                        Download Covernote
                                                    </a>
                                                    @endif
                                                    @if ($value->hasil)
                                                    <a href="/download_hasil?uuidfile={{ $value->uid }}&notaris_id={{ $value->notaris_id }}&bank_id={{ $value->bank_id }}&lembar_id={{ $value->uuid }}"
                                                    target="_blank"
                                                    class="dropdown-item"
                                                    >
                                                        Download Hasil
                                                    </a>
                                                @endif

                                            </div>
                                        </div>
                                    </td> -->
                                    @IsNotaris
                                        <td>
                                        @if($value->status_diterima == 1)
                                        <a href="/tambah_kerjakan/{{$value->uid}}" class="btn btn-primary ">Kerjakan</a>
                                        @endif
                                        </td>
                                    @endIsNotaris
                                    <!-- <td>
                                        <div class="dropdown dropend my-1">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Upload
                                            </button>
                                            <div class="dropdown-menu"
                                            style=" overflow-y: auto;">
                                                @IsBank
                                                <a href="/upload_dokumen/{{$value->uid}}" class="dropdown-item">Upload Dokumen</a>
                                                @endIsBank

                                                @IsNotaris
                                                @if($value->status_dikerjakan == 1)
                                                <a href="/upload_hasil/{{$value->uid}}" class="dropdown-item">Upload Hasil Kerja</a>
                                                @endif
                                                @endIsNotaris
                                            </div>
                                        </div>
                                    </td> -->
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
        function changestatus(uid, status_diterima) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "/changestatus/" + uid,
                method: 'post',
                data: {
                    status_diterima: status_diterima
                },
                success: function(result) {
                    // Swal.fire(
                    //     result.msg,
                    //     'success'
                    // )
                    console.log('tes');
                    Swal.fire({
                        icon: 'success',
                        title: 'Informasi',
                        text: result.msg,
                    })
                    window.location.reload();
                    // console.log(result.data)
                },

            })
        }
        function changestatusselesai(uid, status_selesai) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "/changestatusselesai/" + uid,
                method: 'post',
                data: {
                    status_selesai: status_selesai
                },
                success: function(result) {
                    // Swal.fire(
                    //     result.msg,
                    //     'success'
                    // )
                    console.log('tes');
                    Swal.fire({
                        icon: 'success',
                        title: 'Informasi',
                        text: result.msg,
                    })
                    window.location.reload();
                    // console.log(result.data)
                },

            })
            }
        document.addEventListener("DOMContentLoaded", function() {
            let countdownIntervals = {}; // Simpan interval timer untuk setiap arsip

            function startCountdown(elementId, dueDate) {
                console.log("Element ID:", elementId, "Due Date:", dueDate); // Debugging

                const countDownDate = new Date(dueDate).getTime();
                console.log("Parsed Date:", countDownDate); // Debugging

                if (isNaN(countDownDate)) {
                    console.error("Invalid date format:", dueDate);
                    return;
                }

                const x = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = countDownDate - now;

                    if (distance <= 0) {
                        clearInterval(x);
                        document.getElementById(elementId).innerHTML =
                            "<span class='badge badge-danger' style='color: white; background-color: red; padding: 5px 10px; border-radius: 5px;'>Waktu habis!</span>";
                        return;
                    }
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById(elementId).innerHTML =
                        `<span class='badge badge-warning' style='color: white; background-color: orange; padding: 5px 10px; border-radius: 5px;'>${days}h ${hours}j ${minutes}m ${seconds}d</span>`;
                }, 1000);

                countdownIntervals[elementId] = x; // Simpan interval timer ke dalam objek
            }

            @foreach($lembar_kerja as $value)
                @if(!empty($value->waktu_proses))
                    startCountdown("countdown-{{ $value->uid }}", "{{ \Carbon\Carbon::parse($value->waktu_proses)->format('Y-m-d H:i:s') }}");
                @else
                    document.getElementById("countdown-{{ $value->uid }}").innerHTML =
                        "<span class='badge badge-secondary' style='color: white; background-color: gray; padding: 5px 10px; border-radius: 5px;'>Waktu belum di set</span>";
                @endif
            @endforeach

            // Hentikan timer saat tombol "Kembali" ditekan
            document.querySelectorAll(".return-btn").forEach(button => {
                button.addEventListener("click", function(event) {
                    event.preventDefault(); // Cegah submit langsung
                    let form = this.closest("form");
                    let itemId = this.getAttribute("data-id");

                    // Hapus tampilan timer dari tabel
                    let timerElement = document.getElementById(`countdown-${itemId}`);
                    if (timerElement) {
                        timerElement.innerHTML = "<span class='badge badge-secondary'>Waktu habis</span>";
                    }

                    // Hentikan interval timer
                    if (countdownIntervals[`countdown-${itemId}`]) {
                        clearInterval(countdownIntervals[`countdown-${itemId}`]);
                    }


                    // Submit form setelah 500ms (untuk efek visual)
                    setTimeout(() => {
                        form.submit();
                    }, 500);
                });
            });
        });

    </script>

</div>
@endsection
