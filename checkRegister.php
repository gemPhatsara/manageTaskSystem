<?php
include('connDB.php');
// echo print_r($_POST);
$msg = 0;
$msg2 = "";

$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['name'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$usertype = $_POST['usertype'];


    
if($usertype=='customer'){
    $sql = "INSERT INTO customer (customer_name, customer_lastname, customer_email,customer_tel)
        VALUES ('$name', '$lastname', '$email','$telephone')";
    if ($conn->query($sql) === false) {
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        // echo print_r($conn->errorInfo());
    } else {

        $sqlInsertUser = "INSERT INTO users (username,password,customer_id)";

        $msg = "customer New record created successfully ";
        $sql = "SELECT customer_id FROM customer WHERE customer_name='$name' AND customer_lastname='$lastname' AND customer_email='$email' AND customer_tel='$telephone'";
        $stm = $conn->query($sql);
       
        
        if($stm){
            $User = $stm->fetch(PDO::FETCH_ASSOC);
            $id = $User['customer_id'];

        }    
    }
}
else{
    $sql = "INSERT INTO technician (tech_name,tech_lastname,tech_email,tech_tel)
        VALUES ('$name', '$lastname', '$email','$telephone')";
    if ($conn->query($sql) === false) {
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        // echo print_r($conn->errorInfo());
    } else {

        $sqlInsertUser = "INSERT INTO users (username,password,tech_id)";

        $msg = "Technician New record created successfully ";
        $stm = $conn->query("SELECT tech_id FROM technician WHERE tech_name='$name' AND tech_lastname='$lastname' AND tech_email='$email' AND tech_tel='$telephone'");
        if($stm){
            $User = $stm->fetch(PDO::FETCH_ASSOC);
            $id = $User['tech_id'];

        }
    }
}


$sqlInsertUser .= " VALUES ('$username', '$password', $id)";
if ($conn->query($sqlInsertUser) === false) {
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    // echo print_r($conn->errorInfo());
} else {
    $msg2 = "User New record created successfully ";
    // echo "Error: " . $sql . "";
    
} 

echo $msg;
?>

