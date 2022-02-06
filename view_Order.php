

<!--============================================include css===================================================-->
<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!-- <link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/daterangepicker/daterangepicker.css">-->
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/css/util.css"> 
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/css/main.css">
    <link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/select2/select2.min.css">
<!--============================================include css===================================================-->

<style>
    .show-calendar{
        width:32em !important;
    }
    .calendar{
        width:31em !important;
    }
    .daterangepicker .calendar {
        max-width: none !important;
    }
    .table-condensed{
        font-size: 16px !important;
    }
    .btn-calendar {
        font-size: 15px;
        color: #999999;

        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        align-items: center;
        position: absolute;
        height: 100%;
        top: 0;
        right: 12px;
        padding: 0 5px;
        -webkit-transition: background 0.4s;
        -o-transition: background 0.4s;
        -moz-transition: background 0.4s;
        transition: background 0.4s;
    }
    .select2-container{
        font-size: 16px;
        min-height: 3.2em;
    }
    .select2-selection{
        min-height: 3.2em;
    }
</style>

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
        $column = 'id';
        $type = '';
    }
    $getTechnicianList = $conn->query("SELECT * FROM Technician ");
    $TechnicianList = $getTechnicianList->fetchAll(PDO::FETCH_ASSOC);
    $Address = '';
    if($type != ''){ 
        $getProfile = $conn->query("SELECT {$type}_address FROM [{$table}] where $column = $UsertypeID");
        $Address = $getProfile->fetch(PDO::FETCH_ASSOC);
        $Address = $Address[$type.'_address'];
    }

    $sql = "SELECT product_id,product_name FROM products";
    $getProductList = $conn->query($sql);
    $ProductList = $getProductList->fetchAll(PDO::FETCH_ASSOC);

    $getSupplierList = $conn->query("SELECT supplier_id , supplier_name  FROM suppliers");
    $SupplierList = $getSupplierList->fetchAll(PDO::FETCH_ASSOC);
?>
    <div class="container-login100">
        <div class="wrap-login100 p-l-85 p-r-60 p-t-55 p-b-55" style="width:55%;height: 70em;overflow-y: scroll;">
            <form action="addOrder.php" method="post">
                    <span class="login100-form-title p-b-32">
                        Order
                    </span>

                        <div class="row col-md-12">
                            <div class="col-md-11"></div>
                            <div class="col-md-1">   
                                <div >
                                    <button type="button" id="addOrder" class="btn btn-success btn-add">Add</button>
                                </div>
                            </div>
                        </div>

                        <div id="list-order">

                            <div class="row col-md-4">
                                <div class="col-md-10">
                                    <span class="txt1 p-b-11">
                                        Supllier
                                    </span>
                                    <div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
                                        <span class="focus-input100"></span>
                                        <select name="supllier" class="supllier">   
                                            <?php 
                                            foreach($SupplierList as $Supplier){
                                            ?>
                                            <option value="<?=$Supplier['supplier_id'];?>"><?=$Supplier['supplier_name'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>                 
                                                    
                                    
                            </div>
                            <div class="row col-md-12 product-rows data-rows" data-rows=1>
                                <div class="col-md-7">
                                        <span class="txt1 p-b-11">
                                            Product Name
                                        </span>
                                        <div class="wrap-input100 validate-input m-b-12" data-validate = "Username is required">
                                            <span class="focus-input100"></span>
                                            <select name="productName[]" class="productName">   
                                                <?php 
                                                foreach($ProductList as $Product){
                                                ?>
                                                <option value="<?=$Product['product_id'];?>"><?=$Product['product_name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="col-md-10">     
                                        <span class="txt1 p-b-11">
                                            Quantity
                                        </span>
                                        <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
                                            <input class="input100 quantity number" type="number" min=0 name="quantity[]" data-rows=1>
                                            <span class="focus-input100"></span>
                                        </div>
                                    </div>    
                                

                                    <div class="col-md-2">     
                                            <button type="button" class="btn btn-danger data-rows btn-remove-product" data-rows=1 style="margin-top: 3em;">Remove</button>
                                    </div>
                                    
                                </div>
                                
                            </div>

                        </div>

                        

                        <div class="row col-md-12">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <center>
                                    <button type="submit "class="login100-form-btn" style="display: inline-block;">
                                        Save
                                    </button> 
                                </center>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
            </form>
		</div>
	</div>
<script src="src/moment.js"></script>
<script src="Bootstraplogin/vendor/daterangepicker/daterangepicker.js"></script>
<script>
    $(function() {
        $('input[name="appointment"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'),10),
            locale: {
                format: 'DD/MMM/YYYY'
            }
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
            
        });
    });
</script>
<script type="text/javascript">

    $(document).ready(function(){
        
        $('.supllier').select2();
        $('.productName').select2();
        
        var address = "<?=$Address;?>";
        $('#check').click(function(){
            
            if ($(this).is(':checked')) {
                $('#location').val("");
                $('#location').val(address);
                $('#location').attr('disabled',true);
            }else{
                $('#location').val("");
                $('#location').attr('disabled',false);

            }
        });

        $( "body" ).delegate( ".number", "keyup", function( event ) {
            var val = parseInt($(this).val());
            if(val < 0){
                $(this).val(0);
            }
            $(this).val(val*1);
        });

        $( "body" ).delegate( ".number", "keypress", function( event ) {
            if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
                event.preventDefault(); //stop character from entering input
            }
        });
        var rows = 1;
        $('#addOrder').click(function(){
            rows++;
            $.get("view_AddOrder.php", function (data) {
                $("#list-order").append(data);
                $('.data-rows[data-rows=0]').attr('data-rows',rows);
            });
            
        });

        $( "body" ).delegate( ".btn-remove-product", "click", function( event ) {
            var rows = $(this).attr('data-rows');
            console.log("log :rows: "+rows);
            $('.product-rows[data-rows='+rows+']').remove();
            rows--;

        });

    });

</script>

