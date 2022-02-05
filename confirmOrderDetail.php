<?php
    include('connDB.php');
    date_default_timezone_set('Asia/Bangkok');
    $sDate =  date('Y-m-d H:i:s');

    $ProductID = $_POST['productID'];
    $OrderDetailID = $_POST['orderDetailID'];
    $UnitPrice = $_POST['unitPrice'];
    $Quantity = $_POST['quantity'];
    $CostPrice = $_POST['costPrice'];
    $status = 0;
    foreach($OrderDetailID as $key => $iOrderDetailID){
        $iUnitPrice = $UnitPrice[$key];
        $iQuantity = $Quantity[$key];
        $iProductID = $ProductID[$key];
        $iCostPrice = $CostPrice[$key];

        $sql = "UPDATE products SET cost_price = $iCostPrice , quantity += $iQuantity
                WHERE product_id = $iProductID";
        $UpdateProduct = $conn->query($sql);

        
        $sql = "UPDATE order_detail SET unit_price = $iUnitPrice , quantity = $iQuantity
                WHERE order_detail_id = $iOrderDetailID";
        $UpdateOrderDetail = $conn->query($sql);
        if($UpdateOrderDetail){
            $status++;
        }
    }

    // foreach($ProductID as $key => $iProductID){
    //     $iCostPrice = $CostPrice[$key];
    //     $sql = "UPDATE products SET costPrice = $iCostPrice
    //             WHERE product_id = $iProductID";
    //     $UpdateProduct = $conn->query($sql);
        // if($UpdateProduct){
        //     $status = 1;
        // }
    // }

    $sql = "UPDATE orders SET receive_datetime = '$sDate' ,
            confirm_status = 1 WHERE order_id = (SELECT order_id FROM order_detail WHERE order_detail_id = $OrderDetailID[0])";
    $ConfirmOrder = $conn->query($sql);

    if($ConfirmOrder){
        Header("Location:successLogin.php?confirm_status=$status");
    }else{
        echo "\nPDO::errorInfo():\n";
        print_r($ConfirmOrder->errorInfo());
        die();
    }
    


?>