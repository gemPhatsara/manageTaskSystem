<?php 

    include('connDB.php');
    date_default_timezone_set('Asia/Bangkok');

    $Status = 2;
    $arrayDelete = explode(",",$_POST['DeleteJobID']);
    $TaskDescription = $_POST['taskDescription'];
    $TechnicianID = $_POST['technician'];
    $Appointment = $_POST['appointment'];
    $JobID = $_POST['jobID'];
    $ProductList = $_POST['products'];
    $QuantityList = $_POST['quantity'];
    $Budget = $_POST['budget'];
    // echo "<pre>";
    // print_r($QuantityList);
    // echo "</pre>";
    if(isset($_POST['jobDetailID']) and !empty($_POST['jobDetailID'])){
        $jobDetailList = $_POST['jobDetailID'];
    }
    
    $date = str_replace('/', '-', $Appointment );
    $newDate = date("Y-m-d 00:00:000", strtotime($date));
    $sDate =  date('Y-m-d H:i:s');
    

    foreach($arrayDelete as $jobDetailID){
        if(!empty($jobDetailID)){
            $sql = " DELETE from job_details where job_detail_id = $jobDetailID ";
            $DeletedSelectedProducts = $conn->query($sql);
        }
    }

    foreach($ProductList as $key => $ProductID){
        if(isset($QuantityList[$key]) and $QuantityList[$key] > 0 ){
            $Quantity = $QuantityList[$key];

            if(isset($_POST['jobDetailID']) and !empty($_POST['jobDetailID'])){
                $jobDetailID = $jobDetailList[$key];
                if(!empty($jobDetailID)){
                    $sql = " SELECT * FROM job_details WHERE job_detail_id = $jobDetailID AND job_id = $JobID ";
                }else{
                    $sql = " SELECT * FROM job_details WHERE job_id = $JobID AND product_id = $ProductID AND quantity = $Quantity ";
                }
            }else{
                $sql = " SELECT * FROM job_details WHERE job_id = $JobID AND product_id = $ProductID AND quantity = $Quantity ";
            }
            // echo $sql."<br>";
            $CheckSelectedProducts = $conn->query($sql);
            $SelectedProducts = $CheckSelectedProducts->fetch(PDO::FETCH_ASSOC);
            
            if(!$SelectedProducts ){
                // echo "not innn <br>";
                // echo $sql."<br>";
                $sql = " INSERT INTO job_details (job_id,product_id,quantity) VALUES ($JobID,$ProductID,$Quantity) ";

                $sqlCutStock = "UPDATE products SET quantity -= $Quantity WHERE product_id = $ProductID";
                $CutStock = $conn->query($sqlCutStock); 
                
                // echo $sql."<br>";
                $InsertSelectedProducts = $conn->query($sql);
            }else{
                // echo $sql."<br>";
                // echo "innn <br>";
                $sql = " UPDATE job_details SET product_id = $ProductID , quantity = $Quantity WHERE job_detail_id = $jobDetailID";
                // echo $sql."<br>";
                $UpdateSelectedProducts = $conn->query($sql);
            }
            
        }
        
    }
    $sql = " Update job set description = '$TaskDescription' , tech_id = $TechnicianID , job_date = '$newDate' , status = 2 ,
            budget = $Budget WHERE job_id = $JobID ";
    $EditTask = $conn->query($sql);

    if($EditTask){
        $Status = 1;
    }
    echo $Status;
    // Header("Location:home.php?edit_task_status=$Status");



    


?>