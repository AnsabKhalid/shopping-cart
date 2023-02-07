<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="public/frontend/login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="public/frontend/login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="public/frontend/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="public/frontend/login/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="public/frontend/login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="public/frontend/login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="public/frontend/login/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="public/frontend/login/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="public/frontend/login/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="public/frontend/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="public/frontend/login/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('public/frontend/login/images/bg-01.jpg');">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="{{ url('/access_account') }}" method="POST">
				{{ csrf_field() }}
				<a href="{{ url('/') }}">
					<span class="login100-form-logo">
						<i class="zmdi zmdi-landscape"></i>
					</span>
					</a>

					<span class="login100-form-title p-b-34 p-t-27">
						Log in
					</span>

					@if(count($errors) > 0)
						<div class="alert alert-danger">
							<ul>
								@foreach($errors->all() as $error)
										<li>
											{{ $error }}
										</li>
								@endforeach
							</ul>
						</div>
					@endif

					@if (Session::has('warning'))
						<div class="alert alert-danger">
							{{Session::get('status')}}
						</div>
					@elseif (Session::has('status'))
						<div class="alert alert-success">
							{{Session::get('status')}}
						</div>	
             		@endif

					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Password" id="myInput">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

						<label style="color: #fff; margin: 0 0 30px 0; font-size:15px"><input type="checkbox" onclick="myFunction()"> Show Password</label>

					<!-- <div class="text-left">
						<a class="txt1" href="#">
							Forgot password
						</a>
					</div> -->

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center p-t-90">
						<a class="txt1" href="{{ url('/signup') }}">
							Don't have an accoount ? Sign Up
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="public/frontend/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="public/frontend/login/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="public/frontend/login/vendor/bootstrap/js/popper.js"></script>
	<script src="public/frontend/login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="public/frontend/login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="public/frontend/login/vendor/daterangepicker/moment.min.js"></script>
	<script src="public/frontend/login/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="public/frontend/login/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="public/frontend/login/js/main.js"></script>

	<script>
		function myFunction() {
			var x = document.getElementById("myInput");
			if (x.type === "password") {
				x.type = "text";
			} else {
				x.type = "password";
			}
		}
	</script>

	<!-- <script>
        $(".showpass").click(function(){
		console.log('hi');
		$(".showpass").hide();
		$(".hidepass").show();
		if($('#password').attr("type") === "password"){
			$('#password').attr("type", "text");
		}
		});
		$(".hidepass").click(function(){
		console.log('hi');
		$(".hidepass").hide();
		$(".showpass").show();
		if($('#password').attr("type") === "text"){
			$('#password').attr("type", "password");
		}
		});
</script> -->

</body>
</html>