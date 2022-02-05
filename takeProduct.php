<?php 
    include('connDB.php');
    $Status = 0;
    $JobID = $_POST['jobID'];

    // $sql = "SELECT productID , quantity FROM job_details WHERE jobID = $JobID";
    // $getListForCutStock = $conn->query($sql); 
    // $ProductList = $getListForCutStock->fetchAll(PDO::FETCH_ASSOC);  
    // foreach($ProductList as $Product){
    //     $ProductID = $Product['productID'];
    //     $Quantity = $Product['quantity'];
    //     $sqlCutStock = "UPDATE Products SET quantity -= $Quantity WHERE productID = $ProductID";
    //     $CutStock = $conn->query($sqlCutStock); 
    // }

    $sql = "UPDATE job set status = 5 WHERE job_id = $JobID";
    $TakeProduct = $conn->query($sql); 
    if($TakeProduct){
        $Status= 1;
    }else{
        echo "\nPDO::errorInfo():\n";
        print_r($TakeProduct->errorInfo());
        die();
    }
    echo $Status;
    // Header("Location:successLogin.php?take_status=$Status");

?>