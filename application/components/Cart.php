<?php

namespace application\components;

class Cart
{


    //counts productd in cart
    public static function countItems()
    {
        //check if there is products in ssesion
        if (isset($_SESSION['products'])) {
            //count how many products in ssesion
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        } else {
            //if there is no products return 0
            return 0;
        }
    }
    //futcion returns array of products in cart
    public static function getProducts()
    {
        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }
        return false;
    }
    //function delete product from cart
    public static function deleteProduct($id)
    {
        // get array with ids and quantity of products in cart
        $productsInCart = self::getProducts();
        // delete from array element with specified id
        unset($productsInCart[$id]);
        $_SESSION['products'] = $productsInCart;
    }
    public function getProductIncart($id)
    {
        return $this->model->productsIncartData($id);
    }

    //function counts total price of rpoducts in cart
    public static function getTotalPrice($products)
    {
        //getting array of products in cart(ids and quantity)
        $productsInCart = self::getProducts();
        //counting total price
        $total = 0;
        if ($productsInCart) {
            foreach ($products as $item) {
                // multiply the quantity of product by the price
                $total += $item['price'] * $productsInCart[$item['inStockId']];
            }
        }

        return $total;
    }
    public static function checkLoged()
    {
        if (isset($_SESSION['fullName']))
            return true;
        return false;
    }
}
