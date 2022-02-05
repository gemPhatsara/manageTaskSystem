
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
    
    
</style>
<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/select2/select2.css">
<?php
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
    if(isset($_SESSION['pageno'])){
        $page_no = $_SESSION['pageno'];
    }
    

    include('connDB.php');

    $no_of_records_per_page = 10;
    $offset = ($page_no-1) * $no_of_records_per_page;
    
    if($type == ''){
        $getCountJob = $conn->query("SELECT COUNT(*) as no FROM job ");
    }else{
        $getCountJob = $conn->query("SELECT COUNT(*)  as no FROM job WHERE $column = $UsertypeID");
    }

    
    $total_rows = $getCountJob->fetch(PDO::FETCH_ASSOC);
    $total_pages = ceil($total_rows['no'] / $no_of_records_per_page);

    if($type == ''){
        $sql = "SELECT * FROM job ORDER BY created_at DESC OFFSET $offset ROWS FETCH NEXT $no_of_records_per_page ROWS ONLY";
    }else{
        $sql = "SELECT * FROM job  WHERE $column = $UsertypeID ORDER BY created_at DESC OFFSET $offset ROWS FETCH NEXT $no_of_records_per_page ROWS ONLY";
    }


    $getJob = $conn->query($sql);
    $JobList = $getJob->fetchAll(PDO::FETCH_ASSOC);  

    $Status = array(
        '1' => "New",
        '2' => "Process",
        '3' => "End",
    );
    
    
?>
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-60 p-t-55 p-b-55" style="width:1250px ;height:850px">
            <div class="row">
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>	
            <table class="table table-bordered" style="font-size: 20px">
                    <thead>
                        <tr>
                        <th class="center" scope="col" width="12%">Task No.</th>
                        <th class="center" scope="col">Description</th>
                        <th class="center" scope="col" width="20%">Create Date</th>
                        <th class="center" scope="col" width="12%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no_page = $page_no-1;
                        $i = 1+($no_page*$no_of_records_per_page);
                        foreach($JobList as $Job){
                        ?>
                        <tr>
                            <th class="center" scope="row"><?php echo $i;?></th>
                            <td class="edit-task hover" data-id="<?=$Job['job_id'];?>">
                                <?php echo $Job['description'];?>
                            </td>
                            <td class="center"><?php echo date("d/m/Y H:i", strtotime($Job['created_at']));  ;?></td>
                            <td class="center"><?php echo $Status[$Job['status']];?></td>
                        </tr>
                        <?php $i++; } ?>
                    </tbody>
                    </table>
				
			</div>
            <center>
            
                <ul class="pagination" >
                    <li><a href="?pageno=1">First</a></li>
                    <li class="<?php if($page_no <= 1){ echo 'disabled'; } ?>">
                        <a href="<?php if($page_no <= 1){ echo '#'; } else { echo "?pageno=".($page_no - 1); } ?>">Prev</a>
                    </li>
                    <li class="<?php if($page_no >= $total_pages){ echo 'disabled'; } ?>">
                        <a href="<?php if($page_no >= $total_pages){ echo '#'; } else { echo "?pageno=".($page_no + 1); } ?>">Next</a>
                    </li>
                    <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
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

                <div id="modal-body" style=" overflow-y: scroll; min-height: 64em;">
                    <div class="container-login100" style=" min-height: unset; ">
                        <div class="wrap-login100 p-l-85 p-r-60 p-t-55 p-b-55" style="width:850px">
                            <div class="row">
                                <span class="login100-form-title p-b-32">
                                    Edit Task
                                </span>
                                <form action="editTask.php" method="post">
                                    <div class="row col-md-12">
                                        <div class="col-md-12">
                                            <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
                                                <select class="product-multiple" name="products[]" multiple="multiple">
                                                    <?php 
                                                    $getProductList = $conn->query("SELECT * FROM products ");
                                                    $ProductList = $getProductList->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($ProductList as $Product){
                                                    ?>
                                                        <option value="<?=trim($Product['product_id']);?>">
                                                            <?=$Product['product_name'];?>
                                                        </option>
                                                    <?php  
                                                        }
                                                    ?>
                                                </select>
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
                                                <textarea class="input100"name="taskDescription" id="taskDescription" cols="30" rows="5" style="height: unset;"></textarea>
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
                                                <select class="input100" name="technician" id="technician">
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
                                                <input class="input100" type="text" name="appointment" id="appointment">
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
                                                <textarea class="input100"name="location" id="location" cols="30" rows="5" style="height: unset;"></textarea>
                                            </div>
                                        </div>
                                    </div> 

                                    <input type="text" class="hide" name="jobID" id="jobID" value="">
                                    <div class="row col-md-12">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4">
                                            <center>
                                                
                                                <button type="submit "class="login100-form-btn" style="display: inline-block;" >
                                                    Save
                                                </button> 
                                            </center>
                                        </div>
                                        <div class="col-md-4"></div>
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
    
<script src="src/moment.js"></script>    
<script src="Bootstraplogin/vendor/select2/select2.js"></script>  
<script type="text/javascript">
$(document).ready(function(){
    var products = "";
    $(".edit-task").click(function() {

        var selectedValues = new Array();

		var JobID = $(this).attr('data-id');

        $('#jobID').attr('value',JobID);

		$.ajax({ 
			type: 'POST', 
			url: "http://localhost/manage/getTaskData.php", 
			data: {
				"JobID": JobID,
			}, 
			dataType: 'json',
			success: function(Data) {
                var Jobdate = Data.job_date;
                var date = new Date(Jobdate.substr(0,10));
                var newDate = moment(date).format('DD/MMM/YYYY');
                selectedValues = Data.products;
				$('#taskDescription').html(Data.description);
                $('#technician option[value='+Data.tech_id+']').attr('selected','selected');
                $('#appointment').val(newDate);
                $('#location').html(Data.location);
                
                console.log("log :products: "+selectedValues);
                $('.product-multiple').val(selectedValues).select2();

                $('#myModal').modal('show');
			},
			error: function(Data){
				alert("fdd");
			}
		});
	});

    $('.product-multiple').select2({
        placeholder: "Choose Products",
    });

    
});


</script>