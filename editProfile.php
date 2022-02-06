
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!-- <link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/daterangepicker/daterangepicker.css">-->
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/css/util.css"> 
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/css/main.css">
<!--===============================================================================================-->
<?php 
    
    include('connDB.php');
    session_start();
    if(isset($_SESSION['CustomerID'])){
        $UsertypeID = $_SESSION['CustomerID'];
        $table = 'customer';
        $column = 'customer_id';
        $type = 'customer';
    }
    elseif(isset($_SESSION['TechID'])){
        $UsertypeID = $_SESSION['TechID'];
        $table = 'technician';
        $column = 'tech_id';
        $type = 'tech';
    }
    elseif(isset($_SESSION['ID'])){
        $UsertypeID = $_SESSION['ID'];
        $table = 'administrator';
        $column = 'id';
        $type = '';
    }
    $sql = "SELECT U.username,F.* 
            FROM users U 
            INNER JOIN $table F ON U.$column = F.$column 
            WHERE F.$column = $UsertypeID ";
    $getProfile = $conn->query($sql);
    $Profile = $getProfile->fetch(PDO::FETCH_ASSOC);

?>
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-60 p-t-55 p-b-55" style="width:850px">
            <div class="row">
					<span class="login100-form-title p-b-32">
						Edit Profile
					</span>
                <form action="updateProfile.php" id="from_submit_profile" method="post">
					<div class="row col-md-12">
                        <div class="col-md-6">
                            <span class="txt1 p-b-11">
                                Username
                            </span>
                            
                                <div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
                                    <input class="input100" type="text" name="username" value="<?php echo $Profile['username'];?>" disabled>
                                    <span class="focus-input100"></span>
                                </div>
                        </div> 
                        <div class="col-md-6">   
                        <span class="txt1 p-b-11">
                            Old Password
                        </span>
                        <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required" >
                            <input class="input100" type="password" name="opassword" autocomplete="off" placeholder="old password" >
                            <span class="focus-input100"></span>
                        </div>
                        </div>
                    </div>
                    <div class="row col-md-12">
                        <div class="col-md-6">   
                            <span class="txt1 p-b-11">
                                New Password
                            </span>
                            <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
                                <span class="btn-show-pass">
                                    <i class="fa fa-eye"></i>
                                </span>
                                <input class="input100" type="password" name="npassword" id="npassword" placeholder="new password">
                                <span class="focus-input100"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <span class="txt1 p-b-11">
                                Re-Password
                            </span>
                            <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
                                <span class="btn-show-pass">
                                    <i class="fa fa-eye"></i>
                                </span>
                                <input class="input100" type="password" name="re-password" id="re-password" placeholder="re-new password">
                                <span class="focus-input100"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <span class="txt1 p-b-11">
                                Name
                            </span>
                            <div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
                                <input class="input100" type="text" name="name" value="<?php echo $Profile[$type.'_name'];?>">
                                <span class="focus-input100"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <span class="txt1 p-b-11">
                                Lastname
                            </span>
                            <div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
                                <input class="input100" type="text" name="lastname" value="<?php echo $Profile[$type.'_lastname'];?>" >
                                <span class="focus-input100"></span>
                            </div>
                        </div>
                    </div>


                    <?php if($type != ''){ ?>
                        <div class="row col-md-12">
                            <div class="col-md-6">
                                <span class="txt1 p-b-11">
                                    Email
                                </span>
                                <div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
                                    <input class="input100" type="text" name="email" value="<?php echo $Profile[$type.'_email'];?>" >
                                    <span class="focus-input100"></span>
                                </div>
                            </div>    
                            
                            <div class="col-md-6">
                                <span class="txt1 p-b-11">
                                    Telephone
                                </span>
                                <div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
                                    <input class="input100" type="text" name="telephone" value="<?php echo $Profile[$type.'_tel'];?>" >
                                    <span class="focus-input100"></span>
                                </div>
                            </div>    
                        </div>

                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <span class="txt1 p-b-11">
                                    Address
                                </span>
                                <div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
                                    <textarea class="input100"name="address" id="" cols="30" rows="5" style="height: unset;"><?php echo $Profile[$type.'_address'];?></textarea>
                                    <span class="focus-input100"></span>
                                </div>
                            </div>
                        </div>

                    <?php } ?>      
                
                    <div class="row col-md-12">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <center>
                                    <button type="submit" id="submit" class="login100-form-btn" style="display: inline-block;">
                                        Save
                                    </button> 
                                </center>
                            </div>
                            <div class="col-md-4"></div>
                    </div>
                    
                    </form>
				
			</div>
		</div>
	</div>


<script type="text/javascript">
    $(document).ready(function(){

        $("#from_submit_profile").submit(function(e) {
            var form = $(this);
            var url = form.attr('action');

            var npassword = $('#npassword').val();
            var re_password = $('#re-password').val();
            var update_status = 0;
            if(npassword == re_password){
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), // 
                    success: function(Data)
                    {
                        update_status = Data;
                        if(update_status == 1){
                            var r = confirm("Update Profile Success");
                            window.location.replace("http://localhost/manage/home.php");
                        }else if(update_status == 2){
                            var r = confirm("Old Password Wrong");
                            window.location.replace("http://localhost/manage/home.php");
                        }
                        console.log("Data " +Data);
                        // var r = confirm("Update Profile Success");
                        // window.location.replace("http://localhost/manage/home.php");
                    },
                    error: function(oData){

                        alert("Faild");
                    }
                });
            }else{
                alert("Your password and confirmation password do not match.");
            }
            

            e.preventDefault(); // avoid to execute the actual submit of the form.
            });
        
    });

</script>