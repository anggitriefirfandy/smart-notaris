@extends('layouts.appx')
@section('content')
    <div class="row">
        <div class="card border-0">
            <div class="card-body d-flex align-items-center justify-content-between flex-wrap pb-1">
                <div class="d-flex align-items-center mb-3">
                    <span class="avatar avatar-xl flex-shrink-0">
                        <img src="assets/img/profiles/avatar-31.jpg" class="rounded-circle" alt="img">
                    </span>
                    <div class="ms-3">
                        <h3 class="mb-2">Welcome Back, {{Auth::user()->name}} </h3>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">

					<!-- Widget Info -->
					<div class="col-xxl-8 d-flex">
						<div class="row flex-fill">
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-pink mb-2">
											<i class="ti ti-moneybag fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Total Uang Pending</h6>
										<h3 class="mb-3" id="totalFeeBelum"><span class="fs-12 fw-medium text-danger"></span></h3>

									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-secondary mb-2">
											<i class="ti ti-moneybag fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Total Uang Selesai</h6>
										<h3 class="mb-3" id="totalFeeSelesai"><span class="fs-12 fw-medium text-danger"></span></h3>

									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-info mb-2">
											<i class="ti ti-moneybag fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Total Semua Uang</h6>
										<h3 class="mb-3" id="totalFeeSemua"><span class="fs-12 fw-medium text-danger"></span></h3>

									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-pink mb-2">
											<i class="ti ti-checklist fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Total Lembar Selesai</h6>
										<h3 class="mb-3" id="jumlahSelesai"> <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-down me-1"></i>+11.2%</span></h3>

									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-purple mb-2">
											<i class="ti ti-browser fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Total Lembar Proses</h6>
										<h3 class="mb-3" id="jumlahProses"> <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-up me-1"></i>+10.2%</span></h3>

									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-secondary mb-2">
											<i class="ti ti-browser fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Total Lembar Kerja</h6>
										<h3 class="mb-3" id="jumlahLembarKerja"><span class="fs-12 fw-medium text-danger"></span></h3>

									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-success mb-2">
											<i class="ti ti-users-group fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Total Bank</h6>
										<h3 class="mb-3" id="jumlahBank"> <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-up me-1"></i>+2.1%</span></h3>
									</div>
								</div>
							</div>
							<div class="col-md-3 d-flex">
								<div class="card flex-fill">
									<div class="card-body">
										<span class="avatar rounded-circle bg-info mb-2">
											<i class="ti ti-users-group fs-16"></i>
										</span>
										<h6 class="fs-13 fw-medium text-default mb-1">Total Notaris</h6>
										<h3 class="mb-3" id="jumlahNotaris"><span class="fs-12 fw-medium text-danger"></span></h3>

									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Widget Info -->

					<div class="col-xl-4 d-flex">
                     <div class="card flex-fill">
                        <div class="card-header">
                           <div
                              class="d-flex align-items-center justify-content-between flex-wrap row-gap-2"
                           >
                              <h5>Status Pekerjaan	</h5>
                              <!-- <div class="dropdown">
                                 <a
                                    href="javascript:void(0);"
                                    class="btn btn-white border btn-sm d-inline-flex align-items-center"
                                    data-bs-toggle="dropdown"
                                 >
                                    <i class="ti ti-calendar me-1"></i>This Week
                                 </a>
                                 <ul
                                    class="dropdown-menu dropdown-menu-end p-3"
                                 >
                                    <li>
                                       <a
                                          href="javascript:void(0);"
                                          class="dropdown-item rounded-1"
                                          >This Month</a
                                       >
                                    </li>
                                    <li>
                                       <a
                                          href="javascript:void(0);"
                                          class="dropdown-item rounded-1"
                                          >This Week</a
                                       >
                                    </li>
                                    <li>
                                       <a
                                          href="javascript:void(0);"
                                          class="dropdown-item rounded-1"
                                          >Last Week</a
                                       >
                                    </li>
                                 </ul>
                              </div> -->
                           </div>
                        </div>
                        <div class="card-body">
                           <div id="grafikpiestatus"></div>

                        </div>
                     </div>
                  </div>
					 <script>
						document.addEventListener('DOMContentLoaded', function() {
							$(document).ready(function() {
								$.ajax({
									url: '/getjumlahnotaris',
									type: 'GET',
									dataType: 'json',
									success: function(data) {
										$('#jumlahNotaris').text(data.jumlah);
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
									url: '/getjumlahlembarkerja',
									type: 'GET',
									dataType: 'json',
									success: function(data) {
										$('#jumlahLembarKerja').text(data.jumlah);
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
									url: '/getjumlahbank',
									type: 'GET',
									dataType: 'json',
									success: function(data) {
										$('#jumlahBank').text(data.jumlah);
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
									url: '/getjumlahuangselesaibank',
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
						document.addEventListener('DOMContentLoaded', function () {
							$(document).ready(function () {
								$.ajax({
									url: '/getpiegrafik',
									type: 'GET',
									dataType: 'json',
									success: function (data) {
										$('#selesai').text(data.selesai);
										$('#proses').text(data.prosespengerjaan);
										$('#semua').text(data.semua);

										renderDonutChart(data);
									},
									error: function (xhr, status, error) {
										console.error(error);
									}
								});
							});

							function renderDonutChart(data) {
								var options = {
									series: [data.belumdikerjakan, data.prosespengerjaan, data.selesai],
									chart: {
										type: 'donut',
										height: 250
									},
									labels: ['Belum Dikerjakan', 'Proses Pengerjaan', 'Selesai'],
									colors: ['#6c757d', '#ffc107', '#e83e8c'],
									legend: {
										position: 'bottom'
									}
								};

								var chart = new ApexCharts(document.querySelector("#grafikpiestatus"), options);
								chart.render();
							}
						});
					 </script>
				</div>

@endsection
