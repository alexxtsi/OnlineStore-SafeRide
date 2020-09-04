<?php

$productsArray = $vars['products'];

echo '<div class="container">
        <div class="row">';
for ($i = 0; $i < count($productsArray); $i++) {

    echo
        '<div class="col-md-4 col-sm-6 mt-4 "> 
            <div class="card " style="width: 16rem;">
                <img src="../../../' . $productsArray[$i]->getImgPath() . '" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">' . $productsArray[$i]->getProductName() . '</h5>
                    <p class="card-text">' . $productsArray[$i]->getPrice() . ' $</p>
                    <a  href="/SafeRideStore/productDetails/' . $productsArray[$i]->getProductId()  . '" type="submit" name="btnViewProduct" value="" class="btn btn-primary" >ViewProduct</a>
                </div>
            </div>
        </div>';
}
echo '</div>  </div>';
