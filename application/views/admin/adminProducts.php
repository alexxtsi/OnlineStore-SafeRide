<?php

use application\components\Product;

$products = $vars['products'];
?>
<div class="container">
    <h2>Products in store</h2>
    <div class="row">
        <div class="col-8">
            <div class="pt-2">
                thoes are products that presented in store to see products in stock press the button
            </div>
        </div>
        <div class="col-4">
            <div class="nav justify-content-end m-2">
                <button class="btn btn-primary ml-3" id="menu-toggle">View/Edit Stock</i></button>
            </div>
        </div>
    </div>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>products ID</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Price</th>
                <th></th>

            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($products))
                for ($i = 0; $i < count($products); $i++) {
            ?>
                <tr>
                    <td><?= $products[$i]->getProductId() ?></td>
                    <td><?= $products[$i]->getProductName() ?></td>
                    <td><?= $products[$i]->getCategory() ?></td>
                    <td><?= $products[$i]->getBrand() ?></td>
                    <td><?= $products[$i]->getPrice() ?> $</td>
                    <td class="nav justify-content-end">
                        <a class="btn btn-primary ml-3" href="products/edit/<?= $products[$i]->getProductId() ?>">View/Edit</a>
                        <button data-id="" class="btn btn-primary ml-3" id="menu-toggle">View Stock</i></button>

                    </td>
                </tr>
            <?php
                }
            ?>

        </tbody>
    </table>