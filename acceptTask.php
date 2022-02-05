<?php 
include('connDB.php');
session_start();
$techID = $_SESSION['TechID'];
$Status = $_GET['status'];
$job_id = $_POST['job_id'];
$sqlGetDeny = "SELECT list_tech_deny FROM job WHERE job_id = $job_id";
$GetDeny = $conn->query($sqlGetDeny); 
$Deny = $GetDeny->fetch(PDO::FETCH_ASSOC);
$Deny = $Deny['list_tech_deny'];


if($Status == 4){
    $sql = "UPDATE job set 
        status = $Status , 
        list_tech_deny = '$Deny $techID,'  
    WHERE job_id = $job_id";

}elseif($Status == 3){
    $sql = "UPDATE job set 
            status = $Status , 
            tech_id = $techID 
        WHERE job_id = $job_id";
}
$AcceptTask = $conn->query($sql); 
if($AcceptTask){
    $Status= 1;
}else{
    echo "\nPDO::errorInfo():\n";
    print_r($AcceptTask->errorInfo());
    die();
}
echo $Status;
// Header("Location:successLogin.php?accept_status=$Status");
?>