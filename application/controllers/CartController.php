<?php

namespace application\controllers;

use application\core\Controller;
use application\components\Cart;

class CartController extends Controller
{
    //Action to load cart 
    public function cartAction()
    {
        $vars = array();
        //getting data of products in cart
        $vars['products'] = $this->getProductsData();
        $this->view->render('cart', $vars);
    }
    public function getProductsData()
    {
        $productsInCart = Cart::getProducts();
        $productsData = array();
        //if cart not empty getting products data
        if ($productsInCart) {
            //getting array of products idd (ids from in_stock table )
            $productsIds = array_keys($productsInCart);
            $productsData = $this->model->getProdustsByIds($productsIds);
        }
        return $productsData;
    }
    //
    public function addAjaxAction()
    {
        if (Cart::checkLoged())
            echo ' (' . $this->addProduct() . ')';
        else
            echo "(0) <script>window.alert('Plese log-in to add product to your cart')</script>";
    }
    public function incAjaxAction()
    {
        $productsData = $this->getProductsData();
        $id = intval($this->route['id']);
        $_SESSION['products'][$id]++;
        echo ' ' . Cart::getTotalPrice($productsData) . ' ';
    }
    public function decAjaxAction()
    {
        $productsData = $this->getProductsData();
        $id = intval($this->route['id']);
        $_SESSION['products'][$id]--;
        echo '  ' . Cart::getTotalPrice($productsData) . ' ';
    }

    //Action to delete product from cart
    public function deleteAction()
    {
        Cart::deleteProduct($this->route['id']);
        header("Location: /SafeRideStore/cart");
    }
    private function addProduct()
    {
        //convert to int
        $id = intval($this->route['id']);
        $amount = intval($this->route['amount']);
        $color = $this->route['color'];
        $size = $this->route['size'];
        $inStock = $this->model->ProductInStock($id, $color, $size);
        if ($inStock != null && $inStock['amount'] > 0) {
            $productsInCart = array();
            // check if there if products in cart (session)
            if (isset($_SESSION['products'])) {
                $productsInCart = $_SESSION['products'];
            }
            // check if this product in already in cart
            if (array_key_exists($inStock['inStockId'], $productsInCart)) {
                $productsInCart[$inStock['inStockId']] += $amount;
            } else {
                $productsInCart[$inStock['inStockId']] = $amount;
            }
            $_SESSION['products'] = $productsInCart;
            echo "<script>window.alert('product added to cart')</script>";
        } else
            echo "<script>window.alert('SORRY,this product out of stock')</script>";
        return Cart::countItems();
    }
}
