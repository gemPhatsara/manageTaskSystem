<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
<!--===============================================================================================-->	
<!-- <link rel="icon" type="image/png" href="Bootstraplogin/images/icons/favicon.ico"/> -->
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
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
				
					<span class="login100-form-title p-b-32">
						Register Form
					</span>
<form action="checkRegister.php" method="post" id="from_submit_register">
					<span class="txt1 p-b-11">
						Username
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
						<input class="input100" type="text" name="username" id="username" >
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11">
                        Password
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100" type="password" name="password" id="password" >
						<span class="focus-input100"></span>
					</div>

                    <span class="txt1 p-b-11">
                        Re-Password
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100" type="password" name="re-password" id="re-password" >
						<span class="focus-input100"></span>
					</div>

                    <span class="txt1 p-b-11">
						Name
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
						<input class="input100" type="text" name="name" >
						<span class="focus-input100"></span>
					</div>

                    <span class="txt1 p-b-11">
						Lastname
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
						<input class="input100" type="text" name="lastname" >
						<span class="focus-input100"></span>
					</div>

                    <span class="txt1 p-b-11">
						Email
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
						<input class="input100" type="text" name="email" >
						<span class="focus-input100"></span>
					</div>

                    <span class="txt1 p-b-11">
						Telephone
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
						<input class="input100" type="text" name="telephone" >
						<span class="focus-input100"></span>
					</div>
					
					<div class="flex-sb-m w-full p-b-48">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="radio" name="usertype" value="customer">
							<label class="label-checkbox100" for="ckb1">
								Looking for Tecnician
							</label>
						</div>

                        <div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb2" type="radio" name="usertype" value="technician">
							<label class="label-checkbox100" for="ckb2">
								Looking for customer
							</label>
						</div>
					</div>

                    <div class="" style="margin-left: 7em">
                        <button type="submit" id="submitRegister" class="login100-form-btn">
                            Register
                        </button>
                    </div>

                    </form>
				
			</div>
		</div>
	</div>

	


	
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


<script type="text/javascript">

    $(document).ready(function(){ 
		// เช็ค Username ว่าซ้ำมั้ย
		$('#username').change(function(){
			var username = $(this).val();

			$.ajax({ 
				type: 'POST', 
				url: "http://localhost/manage/checkUserName.php", 
				data: {
					"username": username,
				}, 
				dataType: 'json',
				success: function(Data) {
					if(Data=="1"){
						alert("UserName Exist");
						$('#submitRegister').attr('disabled','disabled');
					}else{
						$('#submitRegister').attr('disabled',false);
					}
				},
				error: function(Data){
					alert("fdd");
				}
			});


		});
		// submit และเช็ค Username,Password
        $("#from_submit_register").submit(function(e) {
            var form = $(this);
            var url = form.attr('action');

            var password = $('#password').val();
            var re_password = $('#re-password').val();

            var update_status = 0;
            if(password == re_password){
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), // serialize แปลงข้อมูลจาก Inputเป็นอาร์เรย์
                    success: function(Data)
                    {
                        register_status = Data;
                        if(register_status == 0){
                            var r = confirm("Register Not Success");
                            window.location.replace("http://localhost/manage/Login.php");
                        }else{
                            var r = confirm(register_status);
                            window.location.replace("http://localhost/manage/Login.php");
                        }
                        console.log("Data " +Data);
                        // var r = confirm("Update Profile Success");
                        // window.location.replace("http://localhost/manage/successLogin.php");
                    },
                    error: function(oData){

                        alert("Faild");
                    }
                });
            }else{
                alert("Your password and confirmation password do not match.");
            }
            

            e.preventDefault(); 
            });
        
    });

</script>