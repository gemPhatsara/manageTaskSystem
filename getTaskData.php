<?php 
include('connDB.php');
$JobID = $_POST['JobID'];
$getJob = $conn->query("SELECT * FROM job WHERE job_id = $JobID"); 
$Job = $getJob->fetch(PDO::FETCH_ASSOC);
$CustomerID = $Job['customer_id'];
$getCustomer = $conn->query("SELECT customer_tel FROM customer WHERE customer_id = $CustomerID "); 
$Customer = $getCustomer->fetch(PDO::FETCH_ASSOC);  
$Job['customer_tel'] = $Customer['customer_tel'];

$arrayDeny = explode(',',$Job['list_tech_deny']);
$getProducts = $conn->query("SELECT job_detail_id, product_id, quantity FROM job_details WHERE job_id = $JobID ORDER BY job_detail_id ASC"); 
if($getProducts){
    $Products = $getProducts->fetchAll(PDO::FETCH_ASSOC);  
    if(!empty($Products)){
        foreach($Products as $Product){
            $ProductID = trim($Product['product_id']);
            $Quantity = trim($Product['quantity']);
            $JobDetailID = trim($Product['job_detail_id']);
            $arrayProductID[] = $ProductID;
            $arrayQuantity[] = $Quantity;
            $arrayJobDetailID[] = $JobDetailID;
        }
    
        $Job['products'] = $arrayProductID;
        $Job['qty'] = $arrayQuantity;
        $Job['jobDetailID'] = $arrayJobDetailID;
        $Job['arrayDeny'] = $arrayDeny;
    }
    
}



echo json_encode($Job);

?>