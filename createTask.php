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
        $column = 'ID';
        $type = '';
    }
    date_default_timezone_set('Asia/Bangkok');
    $TaskDescription = $_POST['taskDescription'];
    $Technician = 0;
    if(isset($_POST['technician']) and !empty($_POST['technician'])){
        $Technician = $_POST['technician'];
    }
    $Appointment = $_POST['appointment'];
    if(isset($_POST['location']) and !empty($_POST['location'])){
        $Location = $_POST['location'];
    }else{
        $getAddress = $conn->query("SELECT {$type}_address from $table WHERE $column = $UsertypeID");
        $Address = $getAddress->fetch(PDO::FETCH_ASSOC);
        $Location = $Address[$type.'_address'];  
        // $Location = $_POST['location'];
    }
    $date = str_replace('/', '-', $Appointment );
    $newDate = date("Y-m-d 00:00:00", strtotime($date));
    $sDate =  date('Y-m-d H:i:s');
    $sql = "INSERT INTO job (tech_id,job_date,description,created_at,$column, location)
    VALUES ($Technician, '$newDate', '$TaskDescription','$sDate',$UsertypeID,'$Location')";
    $insertTask = $conn->query($sql);
    $Status = 0;
    if($insertTask){
        $Status = 1;
    }else{
        echo "\nPDO::errorInfo():\n";
        print_r($insertTask->errorInfo());
        die();
    }
    Header("Location:successLogin.php?create_status=$Status");




?>