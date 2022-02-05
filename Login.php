<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login ManageSystem</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="Bootstraplogin/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/css/util.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/css/main.css">
<!--===============================================================================================-->


</head>

<body>
	<?php
		session_start();
		$_SESSION['CustomerID'] = null;
		$_SESSION['TechID'] = null;
		$_SESSION['ID'] = null;
		$_SESSION['UserID'] = null;
	?>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
				
				<span class="login100-form-title p-b-32">
					Account Login
				</span>
					<form action="checkLogin.php" method="post">
						<span class="txt1 p-b-11">
							Username
						</span>
						<div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
							<input class="input100" type="text" name="username" >
							<span class="focus-input100"></span>
						</div>
					
						<span class="txt1 p-b-11">
							password
						</span>
						<div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
							<span class="btn-show-pass">
								<i class="fa fa-eye"></i>
							</span>
							<input class="input100" type="password" name="password" >
							<span class="focus-input100"></span>
						</div>
						
						<div class="row col-md-12">
							<div class="col-md-5">
								<button type="submit" class="login100-form-btn">
									Login
								</button>
							</div>
							<div class="col-md-2"></div>
							<div class="col-md-5">
								<a href="register.php">
									<button type="button" class="login100-form-btn-blue ">
										Register
									</button>
								</a>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>

	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="Bootstraplogin/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="Bootstraplogin/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="Bootstraplogin/vendor/bootstrap/js/popper.js"></script>
	<script src="Bootstraplogin/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="Bootstraplogin/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="Bootstraplogin/vendor/daterangepicker/moment.min.js"></script>
	<script src="Bootstraplogin/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="Bootstraplogin/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="Bootstraplogin/js/main.js"></script>

</body>
</html>