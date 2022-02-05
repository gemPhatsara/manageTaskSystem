<?php
    include('connDB.php');
    session_start();
    
    $CreateStatus = null;
    $UpdateStatus = null;
    $EditTaskStatus = 2;
    $ConfirmStatus = null;
    $ReceiveStatus = 0;
    $AddOrderStatus = 0;
    $AcceptStatus = 0;
    $TakeProductStatus = 0;
    $_SESSION['pageno'] = 1;
    
    if(isset($_GET['pageno'])){
        $_SESSION['pageno'] =  $_GET['pageno'];
    }

    if(isset($_GET['create_status'])){
        $CreateStatus = $_GET['create_status'];
    }

    if(isset($_GET['update_status'])){
        $UpdateStatus = $_GET['update_status'];
    }

    if(isset($_GET['edit_task_status'])){
        $EditTaskStatus = $_GET['edit_task_status'];
    }

    if(isset($_GET['receive_status'])){
        $ReceiveStatus = $_GET['receive_status'];
    }

    if(isset($_GET['add_order_status'])){
        $AddOrderStatus = $_GET['add_order_status'];
    }

    if(isset($_GET['confirm_status'])){
        $ConfirmStatus = $_GET['confirm_status'];
    }

    if(isset($_GET['accept_status'])){
        $AcceptStatus = $_GET['accept_status'];
    }
    
    if(isset($_GET['take_status'])){
        $TakeProductStatus = $_GET['take_status'];
    }
    
    
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
        $column = 'ID';
        $type = '';
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="src/bootstrap_nav_tab.css">
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
    <title>CREATE TASK</title>
</head>
<style>
    .center-p {
        margin: 0;
        position: absolute;
        top: 25%;
        right: 10%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
</style>
<body>
<?php 
    $menu = 1;
    if(isset($_GET['menu'])){
        $menu = $_GET['menu'];
    }
?>
<div class="container-fluid" style="margin-top:1em">
    
    <div class="row">
        <ul class="nav nav-tabs" style="width: 95%;display: table-cell;">
        
            <li class="<?php echo ($menu=="1" ? "active" : "");?>">
                <a data-toggle="tab" href="#menu1">Task Scheduler</a>
            </li>

            <?php if($type == "customer"){ ?>
                <li class="<?php echo ($menu=="2" ? "active" : "");?>">
                    <a data-toggle="tab" href="#menu2">Create Task</a>
                </li>
            <?php } ?>


            <li class="<?php echo ($menu=="3" ? "active" : "");?>">
                <a data-toggle="tab" href="#menu3">Profile</a>
            </li>

            <?php if($type == ""){ ?>
                <li class="<?php echo ($menu=="4" ? "active" : "");?>">
                    <a data-toggle="tab" href="#menu4">Order</a>
                </li>
                <li class="<?php echo ($menu=="5" ? "active" : "");?>">
                    <a data-toggle="tab" href="#menu5">List Order</a>
                </li>

                <li class="<?php echo ($menu=="6" ? "active" : "");?>">
                    <a data-toggle="tab" href="#menu6">Income</a>
                </li>
            <?php } ?>
        </ul>
        <a href="logout.php">
            <button class="btn" style="background-color: darkgray;font-size: 18px;font-weight: bolder;">Logout</button>
        </a>
    </div>
    <div class="tab-content">
        
        <div id="menu1" class="tab-pane fade <?php echo ($menu=="1" ? "in active" : "");?>"></div>

        <div id="menu2" class="tab-pane fade <?php echo ($menu=="2" ? "in active" : "");?>"></div>

        <div id="menu3" class="tab-pane fade <?php echo ($menu=="3" ? "in active" : "");?>"></div>

        <div id="menu4" class="tab-pane fade <?php echo ($menu=="4" ? "in active" : "");?>"></div>

        <div id="menu5" class="tab-pane fade <?php echo ($menu=="5" ? "in active" : "");?>"></div>

        <div id="menu6" class="tab-pane fade <?php echo ($menu=="6" ? "in active" : "");?>"></div>
    </div>
</div>

<!--===============================================================================================-->
<script src="src/jquery.min.js"></script>
<script src="src/bootstrap.min.js"></script>
<!--===============================================================================================-->

</body>
</html>

<script type="text/javascript">
$(document).ready(function(){



    $("#menu6").load('view_income.php');
    $("#menu5").load('view_listOrder.php');
    $("#menu4").load('view_Order.php');
    $("#menu3").load('editProfile.php');
    $("#menu2").load('view_createTask.php');
    $("#menu1").load('view_taskSchedule.php');


    $('.btn-remove').click(function(){
        var rows = $(this).attr('data-rows');
        console.log("log :rows: "+rows);
        $('.qty-rows[data-rows='+rows+']').remove();
    });
    var create_status = "<?=$CreateStatus;?>";
    var update_status = "<?=$UpdateStatus;?>";
    var edit_task_status = "<?=$EditTaskStatus;?>";
    var receive_status = "<?=$ReceiveStatus;?>";
    var add_order_status = "<?=$AddOrderStatus;?>";
    var confirm_status = "<?=$ConfirmStatus;?>";
    var accept_status = "<?=$AcceptStatus;?>";
    var take_product_status = "<?=$TakeProductStatus;?>";
    
    
    if(create_status == 1){
        var r = confirm("Create Task Success");
        window.location.replace("http://localhost/manage/home.php");
    }
    
    if(edit_task_status == 1){
        var r = confirm("Edit Task Success");
        window.location.replace("http://localhost/manage/home.php");
    }
    if(edit_task_status == 0){
        var r = confirm("Edit Task Not Success");
        window.location.replace("http://localhost/manage/home.php");
    }

    if(receive_status >= 1){
        var r = confirm("Receive Product Success ("+receive_status+")");
        window.location.replace("http://localhost/manage/home.php");
    }

    if(add_order_status >= 1){
        var r = confirm("Add Order Success ("+add_order_status+")");
        window.location.replace("http://localhost/manage/home.php");
    }

    if(confirm_status >= 1){
        var r = confirm("Confirm Order Success ("+confirm_status+")");
        window.location.replace("http://localhost/manage/home.php");
    }

    if(accept_status == 1){
        var r = confirm("Accept Task Success");
        window.location.replace("http://localhost/manage/home.php");
    }else if(accept_status == 4){
        var r = confirm("Deny Task Success");
        window.location.replace("http://localhost/manage/home.php")
    }

    if(take_product_status == 1){
        var r = confirm("Take Product Success");
        window.location.replace("http://localhost/manage/home.php");
    }
    
    
});
</script>


