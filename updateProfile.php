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

    $password = $_POST['npassword'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $Address = $_POST['address'];

    if((isset($_POST['npassword']) and !empty($_POST['npassword'])) and
        (isset($_POST['opassword']) and !empty($_POST['npassword']))
        ){
            
            $password = $_POST['npassword'];
            $old_password = $_POST['opassword'];

            $sql = "SELECT username FROM users WHERE username = (SELECT username FROM users WHERE $column = $UsertypeID) AND password = '$old_password'";
            $CheckPassword = $conn->query($sql);
            $Result = $CheckPassword->fetch(PDO::FETCH_ASSOC);  
            if(isset($Result['username'])){
                $sqlUpdateUserData = "UPDATE $table 
                                        SET {$type}_name='$name', {$type}_lastname='$lastname', {$type}_email='$email', 
                                            {$type}_tel='$telephone', {$type}_address='$Address' 
                                        WHERE $column = $UsertypeID";
                $updateProfile = $conn->query($sqlUpdateUserData);

                $sqlUpdateUserPassword = "UPDATE users SET password = '$password'
                                        WHERE userID = (SELECT userID FROM users WHERE $column = $UsertypeID)";
                $updateProfile = $conn->query($sqlUpdateUserPassword);


                $Status = 0;
                if($updateProfile and $updateProfile){
                    $Status = 1;
                }else{
                    echo "\nPDO::errorInfo():\n";
                    print_r($updateProfile->errorInfo());
                    die();
                }
                // Header("Location:home.php?update_status=$Status");
            }else{
                $Status = 2;
                // Header("Location:home.php?update_status=2");
            }

    }else{

        $updateProfile = $conn->query("UPDATE $table 
        SET {$type}_name='$name', {$type}_lastname='$lastname', {$type}_email='$email', {$type}_tel='$telephone', {$type}_address='$Address' 
        WHERE $column = $UsertypeID");

        $Status = 0;
        if($updateProfile){
            $Status = 1;
        }else{
            echo "\nPDO::errorInfo():\n";
            print_r($updateProfile->errorInfo());
            die();
        }
        // Header("Location:home.php?update_status=$Status");
    }
    echo $Status;


    


?>