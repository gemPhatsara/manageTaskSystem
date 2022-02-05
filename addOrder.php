<?php
    include('connDB.php');
    date_default_timezone_set('Asia/Bangkok');
    $orderDateTime =  date('Y-m-d H:i:s');
    $SupplerID = $_POST['supllier'];
    $ProductList = $_POST['productName'];
    $QuantityList = $_POST['quantity'];


    $sql = "INSERT INTO orders (order_datetime, supplier_id)
                            VALUES ('$orderDateTime', $SupplerID)";
    $stmAddOrder = $conn->query($sql);
    $LAST_Orders_ID = $conn->lastInsertId();

    foreach($ProductList as $key => $Product){
        $Quantity = $QuantityList[$key];
        $UnitPrice = $UnitPriceList[$key];
        $sql = "INSERT INTO order_detail (order_id,product_id,quantity)
        VALUES ('$LAST_Orders_ID', $Product, $Quantity)";
        $AddOrderDetail = $conn->query($sql);

        if($AddOrderDetail){
            $Status++;
        }else{
            echo "\nPDO::errorInfo():\n";
            print_r($AddOrderDetail->errorInfo());
            die();
        }
    }


    header("Location:home.php?add_order_status=$Status");



?>