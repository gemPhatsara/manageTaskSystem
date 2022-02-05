
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
    .color-1{
        color:orange;
    }
    .color-2,.color-3{
        color:blue;
    }
    .color-3{
        color:blue;
    }
    .color-5{
        color:green;
    }
    .bold{
        font-weight: bold;
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
    $Required = "";
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
        // $action = "acceptTask.php";
    }
    elseif(isset($_SESSION['ID'])){
        $UsertypeID = $_SESSION['ID'];
        $table = 'administrator';
        $column = 'ID';
        $type = '';
        $Required = "required";
    }
    if(isset($_SESSION['pageno'])){
        $page_no = $_SESSION['pageno'];
    }
    
    include('connDB.php');

    $no_of_records_per_page = 10;
    $offset = ($page_no-1) * $no_of_records_per_page;
    
    if($type == ''){
        $getCountJob = $conn->query("SELECT COUNT(*) as no FROM job ");
    }elseif($type == 'tech'){
        $getCountJob = $conn->query("SELECT COUNT(*)  as no FROM job WHERE $column = $UsertypeID and status BETWEEN 2 AND 5");
    }elseif($type == 'customer'){
        $getCountJob = $conn->query("SELECT COUNT(*)  as no FROM job WHERE $column = $UsertypeID");
    }

    
    $total_rows = $getCountJob->fetch(PDO::FETCH_ASSOC);
    $total_pages = ceil($total_rows['no'] / $no_of_records_per_page);

    if($type == ''){
        $sql = "SELECT * FROM job ORDER BY created_at DESC,status ASC";

    }elseif($type == 'tech'){



        $sql = "SELECT job_id,tech_id,status FROM job";
        $stm = $conn->query($sql);
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        $sArrayID = '';
        $aJobID = array();
        foreach($result as $result){

            $jobID = $result['job_id'];
            $techID = $result['tech_id'];
            $status = $result['status'];

            $sql = "SELECT list_tech_deny,tech_id FROM job WHERE job_id = $jobID ";
            $stm = $conn->query($sql);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            $strArrayDeny = $result['list_tech_deny'];
            $checkTechID = $result['tech_id'];

            $condition = ')';
            if($strArrayDeny != ''){
                $rest = substr($strArrayDeny, 0, -1); 
                $link = " OR ";
                if($techID == $checkTechID){
                    $link = " AND ";
                }
                $condition = " $link ( list_tech_deny IS NOT NULL AND $UsertypeID NOT IN($rest)  )) ";
            }
            if($status == 4){
                $sql = "SELECT job_id FROM job WHERE job_id = $jobID AND (( $column != $UsertypeID ) $condition";
            }else{
                $sql = "SELECT job_id FROM job WHERE job_id = $jobID AND (( $column = $UsertypeID ) $condition";
            }
            
            // $sql = "SELECT jobID FROM job WHERE jobID = $jobID AND (( $column = $UsertypeID AND list_tech_deny IS NULL ) $condition";

            // $sql = "SELECT jobID FROM job WHERE jobID = $jobID AND (( ($column = $UsertypeID and status = 3 ) or ($column = $UsertypeID AND list_tech_deny IS NULL and status = 4)  ) $condition";

            echo "<br>";
            $stm = $conn->query($sql);
            if($stm){
                $result = $stm->fetch(PDO::FETCH_ASSOC);
                if(isset($result['job_id']) and !empty($result['job_id'])){
                    $aJobID[] = $result['job_id'];
                }
            }
        }
        $strArrayJobID = join(",",$aJobID);
        $sql = "SELECT * FROM job WHERE 
                    job_id IN($strArrayJobID)
                    and status BETWEEN 2 AND 5 
                    ORDER BY created_at DESC,status ASC";

    }elseif($type == 'customer'){
        $sql = "SELECT * FROM job WHERE $column = $UsertypeID  ORDER BY created_at DESC,status ASC";
    }

    $getJob = $conn->query($sql);
    $JobList = array();
    if($getJob){
        $JobList = $getJob->fetchAll(PDO::FETCH_ASSOC);  
    }

    $Status = array(
        '1' => "New",
        '2' => "Process",
        '3' => "Process",
        '4' => "Deny",
        '5' => "Success",
    );
    
    
?>
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-60 p-t-55 p-b-55" style="width:1250px ;height:850px">
            <div class="row">
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
                    // $class = 
                    if($type == 'tech'){
                        $class="edit-task";
                    }elseif($type == ''){
                        $class="edit-task";
                    }
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
                        <td class="center bold color-<?=$Job['status'];?>"><?php echo $Status[$Job['status']];?></td>
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

                                <form action="editTask.php" method="post" id="formEditTask">

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
                                            <div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required" $Required>
                                                <input type="number" class="input100" min=0 name="budget" id="budget">
                                                <span class="focus-input100"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="row col-md-12 from-percent">
                                        <div class="col-md-12">
                                            <span class="txt1 p-b-11">
                                                Percent
                                            </span>
                                            <div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required" disabled>
                                                <input type="number" class="input100" min=0 name="percent" id="percent" value = 35>
                                                <span class="focus-input100"></span>
                                            </div>
                                        </div>
                                    </div> -->


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
                                                <select class="input100" name="technician" id="technician" <?=$disable;?> <?=$Required;?>>
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

                                    <div class="row col-md-12">
                                        <div class="col-md-12">
                                            <span class="txt1 p-b-11">
                                                Telephone Number
                                            </span>
                                            
                                            <div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
                                                <input class="input100" type="text" name="tel" id="tel" disabled>
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
                                                        <button type="button" class="login100-form-btn btn-submit" value = "3" style="display: inline-block; margin: 1em;" >
                                                            Accept
                                                        </button> 

                                                        <button type="button" class="login100-form-btn-red btn-submit" value = "4" style="display: inline-block; margin: 1em;" >
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
                                                    <button type="button" class="login100-form-btn btn-submit"  value = "2" style="display: inline-block;" >
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
    
<script src="src/moment.js"></script>    
<script src="Bootstraplogin/vendor/select2/select2.js"></script>  
<script type="text/javascript">

$(document).ready(function(){
    var products = "";
    var rows = <?=$rows;?>;
    var type = "<?=$type;?>";
    var url = "editTask.php"

    $(function() {
        var fullDate = new Date();
        var min_date = moment(fullDate).format('DD/MMM/YYYY');
        console.log(min_date);
        $('input[name="appointment"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            // minDate:'27/04/2026',
            minDate: min_date,
            maxYear: parseInt(moment().format('YYYY'),10),
            locale: {
                format: 'DD/MMM/YYYY'
            }
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
            
        });
    });

    $(".edit-task").click(function() {
        var selectedValues = new Array();
		var JobID = $(this).attr('data-id');
        var userID = "<?=$UsertypeID;?>";
        console.log("log userID "+userID);
        // var userID = "15";
        $('#jobID').attr('value',JobID);

		$.ajax({ 
			type: 'POST', 
			url: "http://localhost/manage/getTaskData.php", 
			data: {
				"JobID": JobID,
			}, 
			dataType: 'json',
			success: function(Data) {
                console.log( Data.arrayDeny );
                
                var Jobdate = Data.job_date;
                var date = new Date(Jobdate.substr(0,10));
                var newDate = moment(date).format('DD/MMM/YYYY');
                var budget = Data.budget;
                if(type == 'tech'){
                    budget = budget*0.35;
                }
                
                var tel = Data.customer_tel;
                if(typeof(Data.products) != "undefined" && Data.products !== null){
                    $('#qty').html('');
                    $.each(Data.products, function (key, val) {
                        var productID = val;
                        var qty = Data.qty[key];
                        var id = Data.jobDetailID[key];
                        AddQty(id,rows,productID,qty);
                        rows++;
                    });
                }else{
                    $('#qty').html('');
                    AddQty();
                }

                
                $('.btn-add').removeClass('hide');
                $('.check-status').removeClass('hide');
                $('select[name="technician"]').attr('disabled',false);
                $('input[name="budget"]').attr('disabled',false);
                $('input[name="appointment"]').attr('disabled',false);
                $('textarea[name="taskDescription"]').attr('disabled',false);
                $('input[name="budget"]').attr('disabled',false);
                $('input[name="percent"]').attr('disabled',false);


                if(type == 'tech' ){

                    $('.from-percent').addClass('hide');
                    $('.btn-add').addClass('hide');
                    $('select[name="technician"]').attr('disabled','disabled');
                    $('input[name="appointment"]').attr('disabled','disabled');
                    $('textarea[name="taskDescription"]').attr('disabled','disabled');
                    $('input[name="budget"]').attr('disabled','disabled');

                    if(Data.status >= 3 ){
                        console.log("sts "+Data.status);
                        if ( Data.status == 4 ) {
                            if($.inArray(userID, Data.arrayDeny) >= 0){
                                $('.check-status').addClass('hide');
                            }
                        }else{
                            $('.check-status').addClass('hide');
                        }

                        
                    }
                    
                    

                }else if( type == '' ){
                    if(Data.status >= 2){
                        $('.btn-add').addClass('hide');
                        $('.check-status').addClass('hide');
                        $('select[name="technician"]').attr('disabled','disabled');
                        $('input[name="appointment"]').attr('disabled','disabled');
                        $('textarea[name="taskDescription"]').attr('disabled','disabled');
                        $('input[name="budget"]').attr('disabled','disabled');
                        $('input[name="percent"]').attr('disabled','disabled');
                        
                    }
                    if(Data.status == 3){
                        $('.check-status').removeClass('hide');
                        $('.btn-submit').html("Success");
                        url = "takeProduct.php";
                        // $('#formEditTask').attr('action',"takeProduct.php")
                    }
                    if(Data.status >= 5){
                        $('.check-status').addClass('hide');
                        $('.btn-add').addClass('hide');
                    }
                }else if( type == 'customer' ){
                    $('.from-percent').addClass('hide');
                    $('.check-status').addClass('hide');
                    $('#q').addClass('hide');
                    $('input[name="budget"]').attr('disabled','disabled');
                    $('select[name="technician"]').attr('disabled','disabled');
                    $('input[name="appointment"]').attr('disabled','disabled');
                    $('textarea[name="taskDescription"]').attr('disabled','disabled');
                    $('.btn-add').addClass('hide');
                }

                
				$('#taskDescription').html(Data.description);
                $('#technician option[value='+Data.tech_id+']').attr('selected','selected');
                $('#appointment').val(newDate);
                $('#location').html(Data.location);
                $('#budget').val(budget);
                $('#tel').val(tel);
                $('#myModal').modal('show');
                
			},
			error: function(Data){
				alert("fdd");
			}
		});
	});

    
    $('.btn-add').click(function(){
        rows++;
        AddQty(null,rows,1);
        
    });

    function AddQty(id = null, row = 1,productID = 1,qty = null){
        var attr_disabled = "<?=$disable;?>";
        

        
        $.ajax({ 
            type: 'POST', 
            data: {
				"rows": row,
			}, 
            url: "http://localhost/manage/AddQty.php", 
            success: function(Data) {
                $('#qty').append(Data);
                if(qty != null || type == 'customer'){
                    $('.products[data-rows='+row+'] option[value='+productID+']').attr('selected','selected');
                    $('.products[data-rows='+row+']').attr('disabled',attr_disabled);

                    $('.input-quantity[data-rows='+row+']').val(qty);
                    $('.input-quantity[data-rows='+row+']').attr('disabled',attr_disabled);
                    
                    $('.jobDetailID[data-rows='+row+']').attr('value',id);

                    $('.btn-remove[data-rows='+row+']').attr('data-id',id);
                    $('.btn-remove[data-rows='+row+']').attr('disabled',attr_disabled);
                }
                
            },
            error: function(oData){
                alert("fdd");
            }
        });
        
    }



    $( "body" ).delegate( ".btn-remove", "click", function( event ) {
        var rows = $(this).attr('data-rows');
        $('.qty-rows[data-rows='+rows+']').remove();

        var id = $(this).attr('data-id');
        
        var DeleteJobID = $('.DeleteJobID').val();
        DeleteJobID = DeleteJobID+","+id;
        $('.DeleteJobID').attr('value',DeleteJobID);
    });

    $( "body" ).delegate( ".input-quantity", "keyup change", function( event ) {
        var max = 0;
        var row = $(this).attr('data-rows');
        var productID = $('.products[data-rows='+row+']').find('option:selected').val();
        var val = parseInt($(this).val());
        $.ajax({ 
            type: 'POST', 
            data: {
				"productID": productID,
			}, 
            url: "http://localhost/manage/getQuantityProduct.php", 
            dataType:'json',
            success: function(Data) {
                max = Data['quantity'];
                $('.input-quantity[data-rows='+row+']').attr('max',max);
                $('.input-quantity[data-rows='+row+']').val(val*1);

                if(val < 0){
                    $('.input-quantity[data-rows='+row+']').val(0);
                }

                if(val > max){
                    $('.input-quantity[data-rows='+row+']').val(max);
                }
            },
            error: function(Data){
                alert("fdd");
            }
        });
    });
    

   
    $( "body" ).delegate( ".input-quantity", "keypress", function( event ) {
        if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
            event.preventDefault(); //stop character from entering input
        }
    });

    $( "body" ).delegate( ".products", "change", function( event ) {
        var productID = $(this).find('option:selected').val();
        var row = $(this).attr('data-rows');
        $.ajax({ 
            type: 'POST', 
            data: {
				"productID": productID,
			}, 
            url: "http://localhost/manage/getQuantityProduct.php", 
            dataType:'json',
            success: function(Data) {
                max = Data['quantity'];
                var val = $('.input-quantity[data-rows='+row+']').val();

                $('.input-quantity[data-rows='+row+']').attr('max',max);

                if(val < 0){
                    $('.input-quantity[data-rows='+row+']').val(0);
                }

                if(val > max){
                    $('.input-quantity[data-rows='+row+']').val(max);
                }
            },
            error: function(Data){
                alert("fdd");
            }
        });
    });

    $( "body" ).delegate( "#percent", "keyup change", function( event ) {
        var percent = $(this).val();
        $(this).val(percent*1);
        if(percent < 0){
            $(this).val(0);
        }
    });


    $( "body" ).delegate( "#budget", "keyup change", function( event ) {
        var budget = $(this).val();
        $(this).val(budget*1);
        if(budget < 0){
            $(this).val(0);
        }
    });
    
    
    $(".btn-submit").click(function() {
        // var url = form.attr('action');
        var form = $('#formEditTask');
        var status = $(this).val();
        
        if(status > 2){
            url = "acceptTask.php?status="+status;
        }
        
        var budget = $('input[name="budget"]').val();

        var qty = $('input[name="quantity[]"]').val();

        var checkQty = 0;
        $('.input-quantity').each(function() {
            var iQty = $(this).prop('value');
            if(iQty == '' || iQty == 0){
                checkQty++;
            }
        });
        if(budget <= 0 ){
            alert("Please Input Budget");
        }else if(checkQty > 0){
            alert("Please Select Products and Input Quantity of Products");
        }else{
 
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(oData)
                {
                        
                    location.replace("http://localhost/manage/home.php?edit_task_status="+oData);
                },
                error: function(oData){

                    alert("Faild");
                }
            });

        }
        
    });

    
});


</script>