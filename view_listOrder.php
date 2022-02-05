

<!--============================================include css===================================================-->
<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!-- <link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/daterangepicker/daterangepicker.css">-->
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/css/util.css"> 
	<link rel="stylesheet" type="text/css" href="Bootstraplogin/css/main.css">
    <link rel="stylesheet" type="text/css" href="Bootstraplogin/vendor/daterangepicker/daterangepicker.css">
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
</style>

<?php 
    include('connDB.php');
    session_start();
    $page_no = 1;
    if(isset($_SESSION['pageno'])){
        $page_no = $_SESSION['pageno'];
    }
    

    $no_of_records_per_page = 5;
    $offset = ($page_no-1) * $no_of_records_per_page;
    
    $getCountProducts = $conn->query("SELECT COUNT(*) as no FROM orders WHERE confirm_status IS NULL or confirm_status = 0");

    
    $total_rows = $getCountProducts->fetch(PDO::FETCH_ASSOC);
    $total_pages = ceil($total_rows['no'] / $no_of_records_per_page);

    $sql = "SELECT * FROM orders WHERE confirm_status IS NULL or confirm_status = 0 ORDER BY order_id ASC OFFSET $offset ROWS FETCH NEXT $no_of_records_per_page ROWS ONLY";
    $getOrderList = $conn->query($sql);
    $OrderList = $getOrderList->fetchAll(PDO::FETCH_ASSOC);

?>
    <div class="container-login100">
        <div class="wrap-login100 p-l-65 p-r-60 p-t-55 p-b-55" style="width:85%">  
            <table class="table table-bordered" style="font-size: 20px">
                <thead>
                    <tr>
                    <th class="center" scope="col" width="12%">#</th>
                    <th class="center" scope="col">Supplier</th>
                    <th class="center" scope="col">Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no_page = $page_no-1;
                    $i = 1+($no_page*$no_of_records_per_page);
                    foreach($OrderList as $Order){

                        $SupplierID = $Order['supplier_id'];
                        $sql = "SELECT supplier_name FROM suppliers WHERE supplier_id = $SupplierID";
                        $getSupplier = $conn->query($sql);
                        $Supplier = $getSupplier->fetch(PDO::FETCH_ASSOC);
                        $SupplierName = $Supplier['supplier_name'];
                    ?>
                    <tr>
                        <th class="center" scope="row"><?php echo $i;?></th>
                        <td class="check-job-detail hover" data-id="<?=$Order['order_id'];?>">
                            <?php echo $SupplierName;?>
                        </td>
                        <td >
                            <?php echo $Order['order_datetime'];?>
                        </td>
                    </tr>
                    <?php $i++; } ?>
                </tbody>
            </table>

            <center>
            
                <ul class="pagination" >
                    <li><a href="?pageno=1&menu=5">First</a></li>
                    <li class="<?php if($page_no <= 1){ echo 'disabled'; } ?>">
                        <a href="<?php if($page_no <= 1){ echo '#'; } else { echo "?pageno=".($page_no - 1); } ?>&menu=5">Prev</a>
                    </li>
                    <li class="<?php if($page_no >= $total_pages){ echo 'disabled'; } ?>">
                        <a href="<?php if($page_no >= $total_pages){ echo '#'; } else { echo "?pageno=".($page_no + 1); } ?>&menu=5">Next</a>
                    </li>
                    <li><a href="?pageno=<?php echo $total_pages; ?>&menu=5">Last</a></li>
                </ul>
            </center>
		</div>
        
	</div>

    <!-- Modal -->
    <div class="modal fade" id="ConfirmOrderModal" role="dialog">
        <div class="modal-dialog center-p" style="width: 120em; right:16% !important;">
        
            <!-- Modal content-->
            <div class="modal-content" style="width: inherit;">

                <div class="modal-header row col-md-12" style="margin-left: 0px;">

                    <h4 class="modal-title col-md-11">Confirm Order</h4>
                    <button type="button" class="close col-md-1" data-dismiss="modal">&times;</button>

                </div>

                <div id="modal-body" style=" overflow-y: scroll; height: 64em;">
                    <div class="container-login100" style=" min-height: unset; ">
                        <div class="wrap-login100 p-l-85 p-r-60 p-t-55 p-b-55" style="width: 108em;">
                            <div class="row">
                                <span class="login100-form-title p-b-32">
                                    Confirm Order
                                </span>
                                <form action="confirmOrderDetail.php" method="post">
                                    
                                    <div id="orderDetailList">

                                    <div class="qty-rows" data-rows=1>

                                        <div class="row col-md-12">
                                            <div class="col-md-4">
                                                <span class="txt1 p-b-11">
                                                    Product
                                                </span>
                                                <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
                                                    <input class="input100 order-product data-rows" type="text"  data-rows=1 readonly="readonly">
                                                </div>
                                            </div>

                                            <div class="col-md-2">   
                                                <span class="txt1 p-b-11">
                                                    Quantity
                                                </span>
                                                <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
                                                    <input class="input100 order-quantity" type="number" name="quantity[]"  min=0 data-rows=1>
                                                    <span class="focus-input100"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-3">   
                                                <span class="txt1 p-b-11">
                                                    Unit Price
                                                </span>
                                                <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
                                                    <input class="input100 order-unitPrice" type="number" name="unitPrice[]"  min=0 data-rows=1>
                                                    <span class="focus-input100"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-3">   
                                                <span class="txt1 p-b-11">
                                                    Cost Price
                                                </span>
                                                <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
                                                    <input class="input100 order-cost-price data-rows" type="number" name="cost-price[]"  min=0 data-rows=1>
                                                    <span class="focus-input100"></span>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    </div>
                                    <div class="row col-md-12">
                                        <div class="col-md-6">     
                                        </div>    
                                    
                                        <div class="col-md-6">   
                                        </div>
                                    </div>


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
        var rows = 1;
        $('.check-job-detail').click(function(){
            var orderID = $(this).attr('data-id');
            $.ajax({ 
                type: 'POST', 
                url: "http://localhost/manage/getOrderDetail.php", 
                data: {
                    "orderID": orderID,
                }, 
                dataType: 'json',
                success: function(oData) {

                    $('#orderDetailList').html('');
                    console.log("log : success");
                    $.each(oData, function (key, Data) {
                        var orderDetailID = Data.order_detail_id;
                        var productID = Data.product_id;
                        var productName = Data.product_name;
                        var unitPrice = Data.unit_price;
                        var quantity = Data.quantity;
                        
                        AddOrder(rows,orderDetailID,productID,productName,unitPrice,quantity);
                        rows++;
                    });
                    $('#ConfirmOrderModal').modal('show');

                },
                error: function(oData){
                    alert("fdd");
                }

            });
            
        });

        function AddOrder( row = 1,orderDetailID,productID,productName,unitPrice,quantity){
            console.log("log row "+row);
            $.get("AddListToConfirmOrder.php", function (data) {
                $("#orderDetailList").append(data);
                $('.data-rows[data-rows=0]').attr('data-rows',row);
                $('.order-detail-id[data-rows='+row+']').attr('value',orderDetailID);
                $('.order-product-id[data-rows='+row+']').attr('value',productID);
                $('.order-product[data-rows='+row+']').val(productName);
                $('.order-unitPrice[data-rows='+row+']').val(unitPrice);
                $('.order-quantity[data-rows='+row+']').val(quantity);

            });

            // $.ajax({ 
            //     type: 'POST', 
            //     data: {
            //         "rows": row,
            //     }, 
            //     url: "http://localhost/manage/AddQty.php", 
            //     success: function(Data) {
            //         $('#orderDetailList').append(Data);
            //         if(qty != null){
            //             $('.products[data-rows='+row+'] option[value='+productID+']').attr('selected','selected');
            //             $('.quantity[data-rows='+row+']').val(qty);
            //             $('.jobDetailID[data-rows='+row+']').attr('value',id);
            //             $('.btn-remove[data-rows='+row+']').attr('data-id',id);
            //         }
                    
            //     },
            //     error: function(oData){
            //         alert("fdd");
            //     }
            // });
        
    }

    });

</script>

