<?php 
include('connDB.php');
$rows = $_POST['rows'];
$div = "";
$div .= '<div class="qty-rows" data-rows = '.$rows.'>';
$div .= '   <div class="row col-md-12">';
$div .= '       <div class="col-md-6">';
$div .= '           <span class="txt1 p-b-11"> Product </span>';
$div .= '           <input type="text" class="hide jobDetailID" name="jobDetailID[]" data-rows='.$rows.' value="">';
$div .= '           <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">';
$div .= '               <select class="input100 products" name="products[]" data-rows='.$rows.'> ';
                            $getProductList = $conn->query("SELECT * FROM products ");
                            $ProductList = $getProductList->fetchAll(PDO::FETCH_ASSOC);
                            $maxQty = $ProductList[0]['quantity'];
                            foreach($ProductList as $Product){
$div .=                         '<option value="'.trim($Product['product_id']).'">'.$Product['product_name'].'</option>';
                            }
$div .= '               </select>';
$div .= '           </div>';
$div .= '       </div>';

$div .= '       <div class="col-md-3">';   
$div .= '           <span class="txt1 p-b-11"> Quantity </span>';
                        
                    
$div .= '           <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">';
$div .= '               <input class="input100 input-quantity quantity" type="number" max='.$maxQty.' min=0 name="quantity[]" data-rows='.$rows.'>';
$div .= '                   <span class="focus-input100"></span>';
$div .= '           </div>';
$div .= '       </div>';

$div .= '       <div class="col-md-3">';
$div .= '           <div>';
$div .= '               <button type="button" class="btn btn-danger btn-remove" data-id="" data-rows = '.$rows.'>Remove</button>';
$div .= '           </div>';
$div .= '       </div>';
$div .= '   </div>';
$div .= '</div>';
echo $div;
?>