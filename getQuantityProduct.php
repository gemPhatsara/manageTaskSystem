<?php 
include('connDB.php');
$ProductID = $_POST['productID'];
$sql = "SELECT quantity FROM products WHERE product_id = $ProductID";
$getQtyProduct = $conn->query($sql); 
$QtyProduct = $getQtyProduct->fetch(PDO::FETCH_ASSOC);
echo json_encode($QtyProduct);
?>