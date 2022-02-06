
<style>
    .pagination{
        font-weight: bolder;
        width: fit-content;
    }
    .pagination>li>a, .pagination>li>span {
        color: #3794e4 !important;
    }
    .pagination>.disabled>a, 
    .pagination>.disabled>a:focus, 
    .pagination>.disabled>a:hover, 
    .pagination>.disabled>span, 
    .pagination>.disabled>span:focus, 
    .pagination>.disabled>span:hover {
        color: #777 !important;
    }
    .center{
        text-align: center;
    }
    .hover:hover{
        cursor:pointer;
        color:#6d6dea;
    }
    .hide{
        display:none;
    }
    .select2-container{
        width: inherit !important;
    }
    .select2-search__field{
        width: unset !important;
    }
    .select2-selection__choice{
        font-size:16px;
    }
    .btn-remove{
        margin-top: 3em;
    }
    
</style>
<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/select2/select2.css">

<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/css/util.css"> 
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/css/main.css">
<?php
    session_start();
    $disable = '';
    $action = "editTask.php";
    if(isset($_SESSION['CustomerID'])){

        $UsertypeID = $_SESSION['CustomerID'];
        $table = 'customer';
        $column = 'customer_id';
        $type = 'customer';
        $disable = 'disabled';
    }
    elseif(isset($_SESSION['TechID'])){
        $UsertypeID = $_SESSION['TechID'];
        $table = 'technician';
        $column = 'tech_id';
        $type = 'tech';
        $disable = 'disabled';
        $action = "acceptTask.php";
    }
    elseif(isset($_SESSION['ID'])){
        $UsertypeID = $_SESSION['ID'];
        $table = 'administrator';
        $column = 'id';
        $type = '';
    }
    if(isset($_SESSION['pageno'])){
        $page_no = $_SESSION['pageno'];
    }
    
    include('connDB.php');

    $no_of_records_per_page = 10;
    $offset = ($page_no-1) * $no_of_records_per_page;
    
    $getCountJob = $conn->query("SELECT COUNT(*) as no FROM job WHERE status = 5");

    
    $total_rows = $getCountJob->fetch(PDO::FETCH_ASSOC);
    $total_pages = ceil($total_rows['no'] / $no_of_records_per_page);

    $sql = "SELECT * FROM job WHERE status = 5 ORDER BY created_at DESC,status ASC";

    $getJob = $conn->query($sql);
    $JobList = $getJob->fetchAll(PDO::FETCH_ASSOC);  

    $sqlSum = "SELECT sum(budget) as budget FROM job WHERE status = 5";
    $getSumBudget = $conn->query($sqlSum);
    $SumBudget = $getSumBudget->fetch(PDO::FETCH_ASSOC); 
    $Status = array(
        '1' => "New",
        '2' => "Process",
        '3' => "Process",
        '4' => "Deny",
        '5' => "Process",
    );
    
    
?>
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-60 p-t-55 p-b-55" style="width:1250px ;height:850px">
            <div class="row">
            <div class="div-col-md-12 input100">
                <div class="col-md-3">
                    <h3>Total Income : <?=$SumBudget['budget'];?></h3>
                </div>
                <div class="col-md-3">
                    <h3>Total Emolument : <?=$SumBudget['budget']*0.35;?></h3>
                </div>
            </div>
            
            <table class="table table-bordered" style="font-size: 20px">
                <thead>
                    <tr>
                    <th class="center" scope="col" width="12%">Task No.</th>
                    <th class="center" scope="col">Description</th>
                    <th class="center" scope="col" width="20%">Budget</th>
                    <th class="center" scope="col" width="12%">Emolument</th>
                    <th class="center" scope="col" width="12%">Vat.</th>
                    <th class="center" scope="col" width="12%">Net</th>
                    <!-- <th class="center" scope="col" width="20%">Create Date</th> -->
                    
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // $class = 
                    if($type == 'tech'){
                        $class="edit-task";
                    }elseif($type == ''){
                        $class="edit-task";
                    }

                    $no_page = $page_no-1;
                    $i = 1+($no_page*$no_of_records_per_page);
                    foreach($JobList as $Job){
                        $Budget = $Job['budget'];
                        $Emolument = $Job['budget']*0.35;
                        

                        $Balance = $Budget-$Emolument;
                        $Tax = $Balance*0.07;
                        $Net = $Balance-$Tax;
                        $Emolument = round($Emolument,2);
                    ?>
                    <tr>
                        <th class="center" scope="row"><?php echo $i;?></th>
                        <td  data-id="<?=$Job['job_id'];?>">
                            <?php echo $Job['description'];?>
                        </td>
                        <td class="center"><?php echo number_format($Budget);?></td>
                        <td class="center"><?php echo number_format($Emolument);?></td>
                        <td class="center"><?php echo number_format($Tax);?></td>
                        <td class="center"><?php echo number_format($Net);?></td>
                        
                        <!-- <td class="center"><?php //echo date("d/m/Y H:i", strtotime($Job['created_at']));  ;?></td> -->
                        
                    </tr>
                    <?php $i++; } ?>


                    
                </tbody>
            </table>
				
			</div>
            <center>
            
                <ul class="pagination" >
                    <li><a href="?pageno=1&menu=1">First</a></li>
                    <li class="<?php if($page_no <= 1){ echo 'disabled'; } ?>">
                        <a href="<?php if($page_no <= 1){ echo '#'; } else { echo "?pageno=".($page_no - 1); } ?>&menu=1">Prev</a>
                    </li>
                    <li class="<?php if($page_no >= $total_pages){ echo 'disabled'; } ?>">
                        <a href="<?php if($page_no >= $total_pages){ echo '#'; } else { echo "?pageno=".($page_no + 1); } ?>&menu=1">Next</a>
                    </li>
                    <li><a href="?pageno=<?=$total_pages;?>&menu=1">Last</a></li>
                </ul>
            </center>
		</div>
	</div>
</div>    


    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog center-p" style="width: max-content;">
        
            <!-- Modal content-->
            <div class="modal-content" style="width: inherit;">

                <div class="modal-header row col-md-12" style="margin-left: 0px;">

                    <h4 class="modal-title col-md-11">Modal Header</h4>
                    <button type="button" class="close col-md-1" data-dismiss="modal">&times;</button>

                </div>

                <div id="modal-body" style=" overflow-y: scroll; height: 64em;">
                    <div class="container-login100" style=" min-height: unset; ">
                        <div class="wrap-login100 p-l-85 p-r-60 p-t-55 p-b-55" style="width:850px">
                            <div class="row">
                                <span class="login100-form-title p-b-32">
                                    Edit Task
                                </span>

                                <form action="<?=$action;?>" method="post" id="formEditTask">

                                    <!-- Add -->
                                    <div class="row col-md-12">
                                        <div class="col-md-9"></div>
                                        <div class="col-md-3">   
                                            <div >
                                                <button type="button" class="btn btn-success btn-add">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php 
                                        $rows = 1;
                                    ?>
                                    <div id="qty">

                                    </div>

                                    <div class="row col-md-12">
                                        <div class="col-md-12">
                                            <span class="txt1 p-b-11">
                                                Budget
                                            </span>
                                            <div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
                                                <input type="number" class="input100" min=0 name="budget" id="budget">
                                                <span class="focus-input100"></span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row col-md-12">
                                        <div class="col-md-12">
                                            <span class="txt1 p-b-11">
                                                Task Description
                                            </span>
                                            <div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
                                                <textarea class="input100"name="taskDescription" id="taskDescription" cols="30" rows="5" style="height: unset;" <?=$disable;?>></textarea>
                                                <span class="focus-input100"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-md-12">
                                        <div class="col-md-6">     
                                            <span class="txt1 p-b-11">
                                                Technician
                                            </span>
                                            <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
                                                <select class="input100" name="technician" id="technician" <?=$disable;?>>
                                                    <option value="" disabled selected hidden>Choose your Technician...</option>
                                                    <?php 
                                                    $getTechnicianList = $conn->query("SELECT * FROM technician ");
                                                    $TechnicianList = $getTechnicianList->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($TechnicianList as $Technician){
                                                    ?>
                                                        <option value="<?=$Technician['tech_id']?>">
                                                            <?="{$Technician['tech_name']} {$Technician['tech_lastname']}"?>
                                                        </option>
                                                    <?php  
                                                        }
                                                    ?>
                                                </select>
                                                <span class="focus-input100"></span>
                                            </div>
                                        </div>    
                                    
                                        <div class="col-md-6">   
                                            <span class="txt1 p-b-11">
                                                Appointment
                                            </span>
                                            <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
                                                <span class="btn-calendar">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input class="input100" type="text" name="appointment" id="appointment" <?=$disable;?>>
                                                <span class="focus-input100"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row col-md-12">
                                        <div class="col-md-12">
                                            <span class="txt1 p-b-11">
                                                Location
                                            </span>
                                            
                                            <div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
                                                <textarea class="input100"name="location" id="location" cols="30" rows="5" style="height: unset;" disabled></textarea>
                                            </div>
                                        </div>
                                    </div> 

                                    <input type="text" class="hide" name="jobID" id="jobID" value="">
                                    <input type="text" class="hide DeleteJobID"  name="DeleteJobID"  value="">
                                    <div class="row col-md-12">
                                        <?php
                                        if($type == "tech"){
                                        ?>
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8 check-status" >
                                                <center>
                                                    <div class="row">
                                                        <button type="submit "class="login100-form-btn" style="display: inline-block; margin: 1em;" >
                                                            Accept
                                                        </button> 

                                                        <button type="submit "class="login100-form-btn" style="display: inline-block; margin: 1em;" >
                                                            Deny
                                                        </button> 
                                                    </div>
                                                </center>
                                            </div>
                                            <div class="col-md-2"></div>
                                        <?php 
                                        }else{
                                        ?>

                                            <div class="col-md-4"></div>
                                            <div class="col-md-4 check-status">
                                                <center>
                                                    <button type="submit "class="login100-form-btn btn-submit" style="display: inline-block;" >
                                                        Save
                                                    </button> 
                                                </center>
                                            </div>
                                            <div class="col-md-4"></div>
                                        <?php }?>
                                    </div>
                                    
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        
        </div>
    </div>
    