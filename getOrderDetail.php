<?php
    include('connDB.php');
    $OrderID = $_POST['orderID'];

    $sql = "SELECT product_id, order_detail_id, product_id, quantity FROM order_detail WHERE order_id = $OrderID ORDER BY order_detail_id ASC";
    $getOrderList = $conn->query($sql);
    $OrderList = $getOrderList->fetchAll(PDO::FETCH_ASSOC);
    foreach($OrderList as $key => $Order){
        $ProductID = $Order['product_id'];
        $sql = "SELECT product_name FROM products WHERE product_id = $ProductID";
        $getProduct = $conn->query($sql);
        $Product = $getProduct->fetch(PDO::FETCH_ASSOC);
        $OrderList[$key]['productName'] = $Product['product_name'];
    }
    echo json_encode($OrderList);
?>