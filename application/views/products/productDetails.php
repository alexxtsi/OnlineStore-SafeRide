<?php
$product = $vars['controller']->getProductById($vars['productId']); ?>

<div class="row"> 
    <div class="col-md-6 mb-4 mb-md-0">

        <div class="container m-4">

            <div class="row mx-1">

                <div class="col-12 pt-4 text-center">
                    <img src="<?php echo $product->getImgPath(); ?>" class="img-fluid " style="max-height: 350px;">

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4 mb-md-0">
        <div class="container m-4">
            <h4><?php echo $product->getProductName(); ?></h4>
            <p class="mb-2 text-muted text-uppercase small"><?php echo $product->getCategory(); ?></p>
            <p><span class="mr-1 display-4"><strong>$<?php echo $product->getPrice(); ?></strong></span></p>
            <p class="pt-1"><?php echo "DESCRIPTION"; ?></p>
            <div class="table-responsive">
                <table class="table table-sm table-borderless mb-0">
                    <tbody>
                        <tr>
                            <th class="pl-0 w-25" scope="row"><strong>Brand</strong></th>
                            <td class="text-uppercase"><?php echo $product->getBrand(); ?></td>
                        </tr>
                        <tr>
                            <th class="pl-0 w-25" scope="row"><strong>Color</strong></th>
                            <td>Blue</td>
                        </tr>
                        <tr>
                            <th class="pl-0 w-25" scope="row"><strong>Delivery</strong></th>
                            <td>Israel</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="table-responsive mb-2">
                <table class="table table-sm table-borderless">
                    <tbody>
                        <tr>
                            <td class="pl-0 pb-0 w-25">Quantity</td>
                            <td class="pb-0">Select size</td>
                        </tr>
                        <tr>
                            <td class="pl-0">
                                <div class="col-xl-12 col-1">
                                    <div class="qty">
                                        <span onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus bg-dark">-</span>
                                        <input type="number" class="count" id="count" min="0" name="qty" value="1">
                                        <span onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus bg-dark">+</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="mt-1 ml-4">
                                    <div class="form-check form-check-inline pl-0">
                                        <input type="radio" class="form-check-input" value="small" name="sizes" checked>
                                        <label class="form-check-label small text-uppercase card-link-secondary" for="small">Small</label>
                                    </div>
                                    <div class="form-check form-check-inline pl-0">
                                        <input type="radio" class="form-check-input" value="medium" name="sizes">
                                        <label class="form-check-label small text-uppercase card-link-secondary" for="medium">Medium</label>
                                    </div>
                                    <div class="form-check form-check-inline pl-0">
                                        <input type="radio" class="form-check-input" value="large" name="sizes">
                                        <label class="form-check-label small text-uppercase card-link-secondary" for="large">Large</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="pb-0">Color</td>
                        <tr>
                            <td>
                                <select id="colors" class="">
                                    <option value="">Red</option>
                                    <option value="">Blue</option>
                                    <option value="">Gren</option>
                                    <option value="">Pink</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <a href="#" class="btn btn-light btn-md mr-1 mb-2 addToCart" data-id="<?= $product->getProductId() ?>"><i class="fas fa-shopping-cart pr-2"></i>Add to cart</a>
            

        </div>
    </div>
</div>

</section>