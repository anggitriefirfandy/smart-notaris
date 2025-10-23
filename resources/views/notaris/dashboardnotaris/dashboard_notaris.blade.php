@extends('layouts.appx')
@section('content')
<style>
.activity-timeline {
    max-height: 400px;
    overflow-y: auto;
}
.flex-container {
  display: flex;
  justify-content: space-between;
}
</style>
<div class="row">
        <div class="card border-0">
            <div class="card-body d-flex align-items-center justify-content-between flex-wrap pb-1">
                <div class="d-flex align-items-center mb-3">
                    <span class="avatar avatar-xl flex-shrink-0">
                        <img src="{{ $profilePicture }}" class="rounded-circle" alt="img">
                    </span>
                    <div class="ms-3">
                        <h3 class="mb-2">Selamat Datang kembali, {{ Auth::user()->name }} <a href="javascript:void(0);" class="edit-icon"><i class="ti ti-edit fs-14"></i></a></h3>
                        <p>Kamu Punya <span class="text-primary text-decoration-underline" id="jumlahProses"></span> Lembar kerja Berstatus Proses & <span class="text-primary text-decoration-underline" id="jumlahSelesai"></span> Lembar Kerja Berstatus Selesai</p>
                    </div>
                </div>
                <div class="d-flex align-items-center flex-wrap mb-1">
                    <!-- <a href="#" class="btn btn-secondary btn-md me-2 mb-2" data-bs-toggle="modal" data-bs-target="#add_project"><i class="ti ti-square-rounded-plus me-1"></i>Add Project</a>
                    <a href="#" class="btn btn-primary btn-md mb-2" data-bs-toggle="modal" data-bs-target="#add_leaves"><i class="ti ti-square-rounded-plus me-1"></i>Add Requests</a> -->
                </div>
            </div>
        </div>
    </div>
	<div class="row">
			<div class="col-xl-3 col-md-6">
				<div class="card position-relative">
					<div class="card-body">
						<div class="d-flex align-items-center mb-3">
							<div class="avatar avatar-md br-10 icon-rotate bg-primary flex-shrink-0">
								<span class="d-flex align-items-center"><i class="ti ti-delta text-white fs-16"></i></span>
							</div>
							<div class="ms-3">
								<p class="fw-medium text-truncate mb-1">Total Pendapatan</p>
								<h5 id="totalFeeSemua"></h5>
							</div>
						</div>
						<!-- <div class="progress progress-xs mb-2">
							<div class="progress-bar bg-primary" role="progressbar" style="width: 40%"></div>
						</div> -->

						<span class="position-absolute top-0 end-0"><img src="assets/img/bg/card-bg-04.png" alt="Img"></span>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-md-6">
				<div class="card position-relative">
					<div class="card-body">
						<div class="d-flex align-items-center mb-3">
							<div class="avatar avatar-md br-10 icon-rotate bg-secondary flex-shrink-0">
								<span class="d-flex align-items-center"><i class="ti ti-currency text-white fs-16"></i></span>
							</div>
							<div class="ms-3">
								<p class="fw-medium text-truncate mb-1">Total Pendapatan Diterima</p>
								<h5 id="totalFeeSelesai"></h5>
							</div>
						</div>
						<!-- <div class="progress progress-xs mb-2">
							<div class="progress-bar bg-secondary" role="progressbar" style="width: 40%"></div>
						</div> -->

						<span class="position-absolute top-0 end-0"><img src="assets/img/bg/card-bg-04.png" alt="Img"></span>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-md-6">
				<div class="card position-relative">
					<div class="card-body">
						<div class="d-flex align-items-center mb-3">
							<div class="avatar avatar-md br-10 icon-rotate bg-danger flex-shrink-0">
								<span class="d-flex align-items-center"><i class="ti ti-stairs-up text-white fs-16"></i></span>
							</div>
							<div class="ms-3">
								<p class="fw-medium text-truncate mb-1">Total Pendapatan Belum Diterima</p>
								<h5 id="totalFeeBelum"></h5>
							</div>
						</div>
						<!-- <div class="progress progress-xs mb-2">
							<div class="progress-bar bg-pink" role="progressbar" style="width: 40%"></div>
						</div> -->

						<span class="position-absolute top-0 end-0"><img src="assets/img/bg/card-bg-04.png" alt="Img"></span>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-md-6">
				<div class="card position-relative">
					<div class="card-body">
						<div class="d-flex align-items-center mb-3">
							<div class="avatar avatar-md br-10 icon-rotate bg-purple flex-shrink-0">
								<span class="d-flex align-items-center"><i class="ti ti-users-group text-white fs-16"></i></span>
							</div>
							<div class="ms-3">
								<p class="fw-medium text-truncate mb-1">Total Lembar Kerja</p>
								<h5 id="jumlahBerkas"></h5>
							</div>
						</div>
						<!-- <div class="progress progress-xs mb-2">
							<div class="progress-bar bg-purple" role="progressbar" style="width: 40%"></div>
						</div> -->

						<span class="position-absolute top-0 end-0"><img src="assets/img/bg/card-bg-04.png" alt="Img"></span>
					</div>
				</div>
			</div>
		</div>
    <div class="row">
		<div class="col-xl-4 d-flex">
			<div class="card position-relative flex-fill">
				<div class="card-header bg-dark">
					<div class="d-flex align-items-center">
						<span class="avatar avatar-lg avatar-rounded border border-white border-2 flex-shrink-0 me-2">
							<img src="{{ $profilePicture }}" alt="Img">
						</span>
						<div>
							<h5 class="text-white mb-1">{{ Auth::user()->name }}</h5>
							<div class="d-flex align-items-center">
							<p class="text-white fs-12 mb-0">@if(Auth::user()->role_id == 0)
										Admin
									@elseif(Auth::user()->role_id == 1)
										Bank
									@elseif(Auth::user()->role_id == 2)
										Notaris
									@else
										Tidak Diketahui
									@endif</p>

						</div>
						</div>
					</div>

				</div>
				<div class="card-body">
					<div class="mb-3">
						<span class="d-block mb-1 fs-13">Phone Number</span>
						<p class="text-gray-9">{{Auth::user()->notaris->no_hp}}</p>
					</div>
					<div class="mb-3">
						<span class="d-block mb-1 fs-13">Email Address</span>
						<p class="text-gray-9">{{ Auth::user()->email }}</p>
					</div>
					<div class="mb-3">
						<span class="d-block mb-1 fs-13">Alamat</span>
						<p class="text-gray-9">{{Auth::user()->notaris->alamat}}</p>
					</div>
					<div>
						<span class="d-block mb-1 fs-13">Nomor Notaris</span>
						<p class="text-gray-9">{{ Auth::user()->notaris->nomor_notaris }}</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-4 d-flex">
		<div class="card flex-fill">
    <div class="card-header">
        <h5>Recent Activities</h5>
    </div>
    <div class="card-body schedule-timeline activity-timeline" style="max-height: 300px; overflow-y: auto;">
        @if(isset($aktivitas) && $aktivitas->isNotEmpty())
            @foreach ($aktivitas as $item)
                <div class="d-flex align-items-start">
                    <div class="avatar avatar-md avatar-rounded {{ getIconClass($item->nama_proses)['bgColor'] }} flex-shrink-0">
                    </div>
                    <div class="flex-fill ps-3 pb-4 timeline-flow">
                        <p class="fw-medium text-gray-9 mb-1">{{ $item->nama_proses }}</p>

                        <span>{{ \Carbon\Carbon::parse($item->created_at)->format('H:i A') }}</span>
                    </div>
                </div>
            @endforeach
        @else
            <p>Tidak ada aktivitas.</p>
        @endif
    </div>
</div>

</div>
		<div class="col-xl-4 d-flex">
			<div class="card flex-fill">
				<div class="card-header">
					<div class="d-flex align-items-center justify-content-between flex-wrap">
						<h5>Notifications</h5>
						<div>

						</div>
					</div>
				</div>
				<div class="card-body">
					
					<div>
						<div id="notificationsList"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
    <div class="card">
        <div class="card-header">
			<div class="flex-container">
				<h5 class="card-title">Total Lembar Kerja</h5>
				<div>
					<select class="form-select" name="2025" id="totallembarkerjatahun" style="padding-top: 0px; padding-bottom: 0px;">
					</select>
				</div>
	
			</div>

        </div>
        <div class="card-body">
            <div id="ss-line"></div>
        </div>
    </div>
</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					<div class="flex-container">
						<h5 class="card-title">Pekerjaan Selesai Dan Pending</h5>
						<div class="dropdown mb-2" style="display:flex">
							<div style="margin-right: 5px">
								<select name="" id="selectpendingselesaitahun" class="form-select" style="
									padding-top: 0px;
									padding-bottom: 0px;
								">
								</select>
							</div>
							<div>
								<select name="" id="selectpendingselesai" class="form-select" style="
									padding-top: 0px;
									padding-bottom: 0px;
								">
									<option value="0">Pending</option>
									<option value="1">Selesai</option>
									<option value="2" selected>Tampilkan Semua</option>
								</select>
							</div>
						</div>
					</div>

				</div>
				<div class="card-body">
					<div id="grafik-selesai-pending" class="chart-set"></div>
				</div>
			</div>
		</div>

		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        let uid = "{{ Auth::user()->notaris->uid }}"; // Ambil UID dari user yang login
        $.ajax({
            url: '/getaktivitas/' + uid, // Masukkan UID dalam URL
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                if (data.length > 0) {
                    let aktivitasHtml = '';
                    data.forEach(function(item) {
                        let iconClass = getIconClass(item.nama_proses); // Panggil fungsi untuk menentukan ikon
                        aktivitasHtml += `
                            <div class="d-flex align-items-start">
                                <div class="avatar avatar-md avatar-rounded bg-primary flex-shrink-0">
                                    <i class="${iconClass} text-white"></i>
                                </div>
                                <div class="flex-fill ps-3 pb-4 timeline-flow">
                                    <p class="fw-medium text-gray-9 mb-1">
                                        <a href="#">${item.nama_proses}</a>
                                    </p>
									<span>${item.created_notaris_nama ?? item.created_namabank ?? '-'}
                                    </span>
                                    <span>${new Date(item.created_at).toLocaleTimeString()}</span>
                                </div>
                            </div>
                        `;
                    });
                    $(".activity-timeline").html(aktivitasHtml);
                } else {
                    $(".activity-timeline").html("<p>Tidak ada aktivitas.</p>");
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });

        // Fungsi untuk menentukan ikon berdasarkan nama proses
        function getIconClass(namaProses) {
            let namaLower = namaProses.toLowerCase();
            if (namaLower.includes("upload")) {
                return "fas fa-upload"; // Ikon Upload
            } else if (namaLower.includes("download")) {
                return "fas fa-download"; // Ikon Download
            } else if (namaLower.includes("tambah") || namaLower.includes("menambahkan")) {
                return "fas fa-plus-circle"; // Ikon Tambah
            } else if (namaLower.includes("ubah") || namaLower.includes("edit")) {
                return "fas fa-edit"; // Ikon Ubah
            } else {
                return "fas fa-tasks"; // Ikon Default jika tidak cocok
            }
        }
    });
	document.addEventListener('DOMContentLoaded', function() {
    $(document).ready(function() {
        $.ajax({
            url: '/getnotif',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var notificationsContainer = $('#notificationsList'); // Gunakan ID unik
                notificationsContainer.empty(); // Hapus hanya daftar notifikasi, bukan semua konten dalam card-body

                if (response.data.length === 0) {
                    notificationsContainer.append('<p class="text-muted">Tidak ada notifikasi baru.</p>');
                    return;
                }

                response.data.forEach(function(item) {
                    var notificationHtml = `
                        <div class="card shadow-sm mb-3 p-3" id="notif-${item.id}">
                            <div class="d-flex align-items-start">
                                <a href="javascript:void(0);" class="avatar flex-shrink-0">
                                    <img src="assets/img/logo_notif/new.png" class="rounded-circle" alt="img" style="width: 60px; height: 60px; object-fit: cover;">
                                </a>
                                <div class="ms-3">
                                    <h6 class="fs-16 fw-bold text-truncate mb-1">${item.nama}</h6>
                                    <p class="fs-14 mb-2">${item.keterangan ? item.keterangan : 'Tidak ada keterangan'}</p>
                                    <p class="fs-14 mb-2 fw-bold text-primary">Rp${item.fee ? item.fee : 'Belum Ada Fee'}</p>
                                    <div class="d-flex align-items-center mt-2">
                                        <button class="btn btn-success btn-sm me-2 update-status" data-id="${item.id}" data-status="1">Approve</button>
                                        <button class="btn btn-danger btn-sm update-status" data-id="${item.id}" data-status="2">Decline</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    notificationsContainer.append(notificationHtml);
                });
            },
            error: function(xhr, status, error) {
                console.error("Error fetching notifications:", error);
            }
        });

        // Event listener untuk tombol approve/decline menggunakan event delegation
        $(document).on("click", ".update-status", function() {
			let itemId = $(this).data("id");
			let newStatus = $(this).data("status");
			

			$.ajax({
				url: "/update-status",
				type: "POST",
				data: {
					id: itemId,
					status: newStatus,
					_token: $('meta[name="csrf-token"]').attr('content') // CSRF token
				},
				success: function(response) {
					if (response.success) {
						alert("Status berhasil diperbarui!");

						// Hapus notifikasi dari tampilan
						$("#notif-" + itemId).fadeOut(300, function() { $(this).remove(); });
					} else {
						alert("Gagal memperbarui status.");
					}
				},
				error: function(xhr, status, error) {
					console.error("Error updating status:", error);
					alert("Terjadi kesalahan. Coba lagi.");
				}
			});
		});

    });
});

	document.addEventListener('DOMContentLoaded', function() {
		$(document).ready(function() {
			$.ajax({
				url: '/getjumlahproses',
				type: 'GET',
				dataType: 'json',
				success: function(data) {
					$('#jumlahProses').text(data.jumlah);
					// console.log(data);
				},
				error: function(xhr, status, error) {
					console.error(error);
				}
			});
		});
	});

	document.addEventListener('DOMContentLoaded', function() {
		$(document).ready(function() {
			$.ajax({
				url: '/getjumlahselesai',
				type: 'GET',
				dataType: 'json',
				success: function(data) {
					$('#jumlahSelesai').text(data.jumlah);
					$('#jumlahBerkas').text(data.jumlahberkas);
					// console.log(data);
				},
				error: function(xhr, status, error) {
					console.error(error);
				}
			});
		});
	});

	document.addEventListener('DOMContentLoaded', function() {
        $(document).ready(function() {
            $.ajax({
                url: '/getjumlahuangselesai',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#totalFeeSelesai').text("Rp " + new Intl.NumberFormat('id-ID').format(data.total_fee_selesai));
                    $('#totalFeeBelum').text("Rp " + new Intl.NumberFormat('id-ID').format(data.total_fee_belum));
                    $('#totalFeeSemua').text("Rp " + new Intl.NumberFormat('id-ID').format(data.total_fee_semua));
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
	$(document).ready(function() {
		let chart; 
		let semuaDataSelesai = [];
		let semuaDataPending = [];
		let semuaBulan = [];
		let tahun = [];
		let tahunSekarang = new Date().getFullYear();
		let selectTahun = $('#selectpendingselesaitahun');
		let tahunMulai = 2020;
		for (let th = tahunSekarang; th >= tahunMulai; th--) {
			selectTahun.append(`<option value="${th}">${th}</option>`);
		}
		selectTahun.val(tahunSekarang);
	
		function filterData() {
			let tahunDipilih = $('#selectpendingselesaitahun').val();
			let statusDipilih = $('#selectpendingselesai').val();

			// console.log("Filter: Tahun =", tahunDipilih, "Status =", statusDipilih);

			// Ambil hanya data tahun yang dipilih
			let selesaiFiltered = semuaDataSelesai.filter(item => item.bulan.startsWith(tahunDipilih));
			let pendingFiltered = semuaDataPending.filter(item => item.bulan.startsWith(tahunDipilih));

			// Ambil semua bulan unik dari data yang difilter
			semuaBulan = [...new Set([...selesaiFiltered, ...pendingFiltered].map(item => item.bulan))].sort();

			// Map bulan -> total
			let mapSelesai = {};
			selesaiFiltered.forEach(item => mapSelesai[item.bulan] = item.total);

			let mapPending = {};
			pendingFiltered.forEach(item => mapPending[item.bulan] = item.total);

			let dataSelesai = semuaBulan.map(bulan => mapSelesai[bulan] || 0);
			let dataPending = semuaBulan.map(bulan => mapPending[bulan] || 0);

			let formatter = new Intl.DateTimeFormat("en-us", {
				year: "numeric",
				month: "2-digit",
			});
			let dateFormatted = semuaBulan.map(dateStr => {
				const dateObj = new Date(`${dateStr}-01`);
				return formatter.format(dateObj);
			});

			// Update chart sesuai status
			if (!chart) return;

			if (statusDipilih === "0") {
				chart.updateOptions({
					xaxis: { categories: dateFormatted },
					series: [{ name: "Pending", data: dataPending }]
				});
			} else if (statusDipilih === "1") {
				chart.updateOptions({
					xaxis: { categories: dateFormatted },
					series: [{ name: "Selesai", data: dataSelesai }]
				});
			} else {
				chart.updateOptions({
					xaxis: { categories: dateFormatted },
					series: [
						{ name: "Pending", data: dataPending },
						{ name: "Selesai", data: dataSelesai }
					]
				});
			}
		}
		
		function renderChart() {
			var options = {
				chart: {
					type: 'bar',
					height: 350
				},
				series: [
				],
				xaxis: {
					categories: []
				},
				colors: ['#28a745', '#ffc107'],
				plotOptions: {
					bar: {
						columnWidth: '50%',
						endingShape: 'rounded'
					}
				},
				dataLabels: { enabled: true },
				legend: { position: 'top' }
			};

			chart = new ApexCharts(document.querySelector("#grafik-selesai-pending"), options);
			chart.render();
		}

		$.ajax({
			url: '/getgrafiklembarkerja',
			type: 'GET',
			dataType: 'json',
			success: function(data) {
				// console.log(data);

				semuaDataSelesai = data.grafik_selesai;
				semuaDataPending = data.grafik_pending;
				
				renderChart();
				filterData();

				
			},
			error: function(xhr, status, error) {
				console.error(error);
			}
		});
	
			// Event listener
		$('#selectpendingselesai').on('change', filterData);
		$('#selectpendingselesaitahun').on('change', filterData);
	});

	$(document).ready(function () {
		let chart;
		let semuaData = [];
		let semuaBulan = [];
		let tahunSekarang = new Date().getFullYear();
		let selectTahun = $('#totallembarkerjatahun');
		let tahunMulai = 2020
		for (let th = tahunSekarang; th >= tahunMulai; th--) {
			selectTahun.append(`<option value="${th}">${th}</option>`);
			
		}
		selectTahun.val(tahunSekarang);

		function filterData() {
			
			let tahunDipilih = $('#totallembarkerjatahun').val();
			let datatahun = semuaData.filter(item => item.bulan.startsWith(tahunDipilih));
			semuaBulan = [...new Set([...datatahun].map(item => item.bulan))].sort();
			let mapData = {};
			datatahun.forEach(item => mapData[item.bulan] = item.total);
			let formatter = new Intl.DateTimeFormat("en-us", {
				year: "numeric",
				month: "2-digit",
			});
			// let dateFormatted = semuaBulan.map(date => formatter.format(semuaBulan));
			// console.log(dateFormatted);
			let dateFormatted = semuaBulan.map(dateStr => {
			const dateObj = new Date(`${dateStr}-01`);
			return formatter.format(dateObj);
			});
			console.log(dateFormatted);

			let data = semuaBulan.map(bulan => mapData[bulan] || 0);
			if (!chart)
				return;
			chart.updateOptions({
				xaxis: {categories: dateFormatted},
				series: [{name: "data", data: data}]
			});
		}
		function renderChart() {
			var options = {
                series: [],
                chart: {
                    type: "line",
                    height: 350
                },
                stroke: {
                    width: 2,
                    curve: "smooth"
                },
                xaxis: {
                    categories: [],
                    
                },
                yaxis: {
                    title: {
                        text: "Total Lembar Kerja"
                    }
                },
                colors: ["#fd7e14"],
                markers: {
                    size: 5,
                    colors: ["#007bff"],
                    strokeColors: "#ffffff",
                    strokeWidth: 2
                },
                tooltip: {
                    theme: "dark"
                }
            };
			chart = new ApexCharts(document.querySelector('#ss-line'), options);
			chart.render();
		}
		$.ajax({
			url: "/gettotallembarbulan", // Sesuaikan dengan route API Laravel
			type: "GET",
			dataType: "json",
			success: function (response) {
				// let labels = []; // Nama bulan
				// let data = [];   // Jumlah lembar kerja
				console.log(response);
				semuaData = response.data;
				renderChart();
				filterData();
			},
			error: function (xhr, status, error) {
				console.error("Error fetching data:", error);
			}
		});
		$('#totallembarkerjatahun').on('change', filterData);
	});




</script>
	</div>
@endsection
