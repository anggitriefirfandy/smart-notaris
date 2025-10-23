
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="Smarthr - Bootstrap Admin Template">
	<meta name="keywords" content="admin, estimates, bootstrap, business, html5, responsive, Projects">
	<meta name="author" content="Dreams technologies - Bootstrap Admin Template">
	<meta name="robots" content="noindex, nofollow">
	<title>Minuta</title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/icon-minuta.png">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Feather CSS -->
	<link rel="stylesheet" href="assets/plugins/icons/feather/feather.css">

	<!-- Tabler Icon CSS -->
	<link rel="stylesheet" href="assets/plugins/tabler-icons/tabler-icons.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/style.css">


</head>
<body class="bg-white">

	<div id="global-loader" style="display: none;">
		<div class="page-loader"></div>
	</div>
<div class="main-wrapper">

		<div class="container-fuild">
			<div class="w-100 overflow-hidden position-relative flex-wrap d-block vh-100">
				<div class="row">
					<div class="col-lg-5">
                    <div class="d-lg-flex align-items-center justify-content-center d-none flex-wrap vh-100 bg-primary-transparent">
							<div>
								<img src="{{asset('assets/img/login-minuta-gambar.png')}}" alt="Img">
							</div>
						</div>
					</div>
					<div class="col-lg-7 col-md-12 col-sm-12">
						<div class="row justify-content-center align-items-center vh-100 overflow-auto flex-wrap">
							<div class="col-md-7 mx-auto vh-100">
									<div class="vh-100 d-flex flex-column justify-content-between p-4 pb-0">
										<div class=" mx-auto mb-5 text-center">
											<img src="{{asset('assets/img/minuta-logo-teks-2.png')}}"
												class="img-fluid" alt="Logo">
										</div>
                                        <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                            <div class="">
                                                <div class="text-center mb-3">
                                                    <h2 class="mb-2">Sign In</h2>
                                                    <p class="mb-0">Please enter your details to sign in</p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Email Address</label>
                                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
													<label class="form-label">Password</label>
													<div class="input-group">
														<input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
															name="password" required autocomplete="current-password">
														<button class="btn btn-outline-secondary" type="button" id="togglePassword">
															<i class="fa fa-eye" id="eyeIcon"></i>
														</button>
													</div>
													@error('password')
														<span class="invalid-feedback d-block" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
												</div>
												<div class="mb-3">
													<div class="g-recaptcha" data-sitekey="6Ldm7WIrAAAAAGMzsjMx_9-__yNYGoIs1E0Dojca"></div>
													@if ($errors->has('g-recaptcha-response'))
														<span class="invalid-feedback d-block">
															<strong>{{ $errors->first('g-recaptcha-response') }}</strong>
														</span>
													@endif
												</div>
                                                <!-- <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                            <label class="form-check-label" for="remember">
                                                                {{ __('Remember Me') }}
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div> -->
                                                <div class="mb-3">
                                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                                                </div>
                                                <!-- <div class="text-center">
                                                    <h6 class="fw-normal text-dark mb-0">Don’t have an account?
                                                        <a href="register.html" class="hover-a"> Create Account</a>
                                                    </h6>
                                                </div> -->

                                            </div>
                                        </form>
                                        <div class="mt-5 pb-4 text-center">
											<p class="mb-0 text-gray-9">Copyright &copy; 2024 - SmartNotaris</p>
										</div>
									</div>

							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <script src="{{asset('assets/js/jquery-3.7.1.min.js')}}"></script>

	<!-- Bootstrap Core JS -->
	<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

	<!-- Feather Icon JS -->
	<script src="{{asset('assets/js/feather.min.js')}}"></script>

	<!-- Custom JS -->
	<script src="{{asset('assets/js/script.js')}}"></script>
	<script src='https://www.google.com/recaptcha/api.js' async defer></script>
	<script>
	function checkRecaptcha() {
	var response = grecaptcha.getResponse();
	if(response.length == 0) {
		//reCaptcha not verified
		alert("no pass");
	}
	else {
		//reCaptch verified
		alert("pass");
	}
	}

	// implement on the backend
	function backend_API_challenge() {
		var response = grecaptcha.getResponse();
		$.ajax({
			type: "POST",
			url: 'https://www.google.com/recaptcha/api/siteverify',
			data: {"secret" : "(your-secret-key)", "response" : response, "remoteip":"localhost"},
			contentType: 'application/x-www-form-urlencoded',
			success: function(data) { console.log(data); }
		});
	}
	document.addEventListener("DOMContentLoaded", function () {
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");
        const eyeIcon = document.querySelector("#eyeIcon");

        togglePassword.addEventListener("click", function () {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            eyeIcon.classList.toggle("fa-eye");
            eyeIcon.classList.toggle("fa-eye-slash");
        });
    });
</script>
</body>
</html>
