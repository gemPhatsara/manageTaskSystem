<?php 
    session_start();
            if(isset($_POST['username'])){
                    include("connDB.php");
                    $username = $_POST['username'];
                    $password = $_POST['password'];

                    $stm = $conn->query("SELECT * FROM users where username='$username' and password='$password'");
                    $User = $stm->fetch(PDO::FETCH_ASSOC);

                        if(!empty($User)){
                            $_SESSION["UserID"] = $User['UserID'];

                            if(!empty($User['ID'])){

                                $_SESSION["ID"] = $User['ID'];
                            }
                            elseif(!empty($User['customer_id'])){
                                
                                $_SESSION["CustomerID"] = $User['customer_id'];
                            }
                            else{
                                $_SESSION["TechID"] = $User['tech_id'];
                            }
                            Header("Location:successLogin.php");

                        }
                        else{
                        echo "<script>";
                        echo "alert(\" user หรือ  password ไม่ถูกต้อง\");"; 
                        echo "window.history.back()";
                        echo "</script>";
                    }
            }else{
    
                Header("Location:Login.html"); //user & password incorrect back to login again
    
            }
    ?>