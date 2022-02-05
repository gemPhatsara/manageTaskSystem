<?php 
    include('connDB.php');
    $ProductNameList = $_POST['product_name'];
    $ProductDescriptionList = $_POST['productDescription'];
    $ProductQuantityList = $_POST['quantity'];
    $ProductUnitPriceList = $_POST['unit-price'];
    $Status = 0;

    foreach($ProductNameList as $key => $ProductName){
        $ProductDescription = $ProductDescriptionList[$key];
        $ProductQuantity = $ProductQuantityList[$key];
        $ProductUnitPrice = $ProductUnitPriceList[$key];

        if(!empty($ProductQuantity) and  !empty($ProductUnitPrice)){
            $sql = "INSERT INTO products (product_name,description,quantity,unit_price)
                        VALUES ('$ProductName', '$ProductDescription', $ProductQuantity,$ProductUnitPrice)";
            $insertProduct = $conn->query($sql);
            
            if($insertProduct){
                $Status++;
            }else{
                echo "\nPDO::errorInfo():\n";
                print_r($insertProduct->errorInfo());
                die();
            }
        }
    }

    
    Header("Location:successLogin.php?receive_status=$Status");

?>