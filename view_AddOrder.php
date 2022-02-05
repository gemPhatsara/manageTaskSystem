
<?php 
    include('connDB.php');
    $getProductList = $conn->query("SELECT product_id , product_name  FROM products");
    $ProductList = $getProductList->fetchAll(PDO::FETCH_ASSOC);

    $getSupplierList = $conn->query("SELECT supplier_id , supplier_name  FROM suppliers");
    $SupplierList = $getSupplierList->fetchAll(PDO::FETCH_ASSOC);

    ?>
        <div class="row col-md-12 product-rows data-rows" data-rows=0>
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
                        <input class="input100 quantity number" type="number" min=0 name="quantity[]" data-rows=0>
                        <span class="focus-input100"></span>
                    </div>
                </div>    
            

                <div class="col-md-2">     
                        <button type="button" class="btn btn-danger data-rows btn-remove-product" data-rows=0 style="margin-top: 3em;">Remove</button>
                </div>
                
            </div>
            
        </div>

<script type="text/javascript">
$(document).ready(function(){
    $('.productName').select2();
    $('.supllier').select2();
    
});

</script>