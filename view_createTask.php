

<!--============================================include css===================================================-->
    <link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!-- <link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/daterangepicker/daterangepicker.css">-->
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/css/util.css"> 
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/css/main.css">
    <link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/daterangepicker/daterangepicker.css">
<!--============================================include css===================================================-->

<style>
    .show-calendar{
        width:32em !important;
    }
    .calendar{
        width:31em !important;
    }
    .daterangepicker .calendar {
        max-width: none !important;
    }
    .table-condensed{
        font-size: 16px !important;
    }
    .btn-calendar {
        font-size: 15px;
        color: #999999;

        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        align-items: center;
        position: absolute;
        height: 100%;
        top: 0;
        right: 12px;
        padding: 0 5px;
        -webkit-transition: background 0.4s;
        -o-transition: background 0.4s;
        -moz-transition: background 0.4s;
        transition: background 0.4s;
    }
</style>

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
    $getTechnicianList = $conn->query("SELECT * FROM technician ");
    $TechnicianList = $getTechnicianList->fetchAll(PDO::FETCH_ASSOC);
    $Address = '';
    $sql = "SELECT {$type}_address FROM {$table} where $column = $UsertypeID";
    
    $getProfile = $conn->query($sql);

    $Address = $getProfile->fetch(PDO::FETCH_ASSOC);
    $Address = $Address[$type.'_address'];
?>
    <div class="container-login100">
        <div class="wrap-login100 p-l-85 p-r-60 p-t-55 p-b-55" style="width:850px">
            <div class="row">
                <span class="login100-form-title p-b-32">
                    Create Task
                </span>
                <form action="createTask.php" method="post">
					<div class="row col-md-12">
                        <div class="col-md-12">
                            <span class="txt1 p-b-11">
                                Task Description
                            </span>
                            <div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
                                <textarea class="input100"name="taskDescription" id="taskDescription" cols="30" rows="5" style="height: unset;" required></textarea>
                                <span class="focus-input100"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row col-md-12">
                        <div class="col-md-6">     
                            <span class="txt1 p-b-11">
                                Technician
                            </span>
                            <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
                                <select class="input100" name="technician" id="technician">
                                    <option value="" disabled selected hidden>Choose your Technician...</option>
                                    <?php 
                                    foreach($TechnicianList as $Technician){
                                    ?>
                                        <option value="<?=$Technician['tech_id']?>"><?="{$Technician['tech_name']} {$Technician['tech_lastname']}"?></option>
                                    <?php 
                                        }
                                    ?>
                                </select>
                                <span class="focus-input100"></span>
                            </div>
                        </div>    
                    
                        <div class="col-md-6">   
                            <span class="txt1 p-b-11">
                                Appointment
                            </span>
                            <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
                                <span class="btn-calendar">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input class="input100" type="text" name="appointment">
                                <span class="focus-input100"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12">
                        <div class="col-md-12">
                            <input class="" type="checkbox" id="check" style="width:2em ;height:2em; margin-right: 1em;" >
                            <span class="txt1 p-b-11">
                                Location
                            </span>
                            
                            <div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
                                <textarea class="input100"name="location" id="text-location" cols="30" rows="5" style="height: unset;" required></textarea>
                            </div>
                        </div>
                    </div> 

                    <div class="row col-md-12">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <center>
                                <button type="submit "class="login100-form-btn" style="display: inline-block;">
                                    Create
                                </button> 
                            </center>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                    
                </form>
				
			</div>
		</div>
	</div>
<script src="src/moment.js"></script>
<script src="Bootstraplogin/vendor/daterangepicker/daterangepicker.js"></script>
<script>
    $(function() {
        var fullDate = new Date();
        var min_date = moment(fullDate).format('DD/MMM/YYYY');
        console.log(min_date);
        $('input[name="appointment"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            // minDate:'27/04/2026',
            minDate: min_date,
            maxYear: parseInt(moment().format('YYYY'),10),
            locale: {
                format: 'DD/MMM/YYYY'
            }
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
            
        });
    });
</script>
<script type="text/javascript">

    $(document).ready(function(){
        
        var address = "<?=$Address;?>";
        $('#check').click(function(){
            if ($(this).is(':checked')) {
                $('#text-location').val("");
                $('#text-location').val(address);
                $('#text-location').html(address);
                $('#text-location').attr('disabled',true);
            }else{
                $('#text-location').val("");
                $('#text-location').attr('disabled',false);

            }
        });

    });

</script>

