<?php

namespace application\controllers;

use application\core\Controller;
use application\components\Cart;
use application\models\ProductsModel;
/**
 * cart Controller 
 * Includes functions for work with user cart such as mange cart, add or dele products from cart and proceed order.
 */
class CartController extends Controller
{
    /**
     * Action for cart page
     */
    public function cartAction()
    {
        $vars = array();
        //getting data of products in cart
        $vars['products'] = $this->getProductsData();
        $this->view->render('cart', $vars);
    }
    /**
     * Function gets relevant data for products in cart
     * @return array $productsData poducts in cart data
     */
    public function getProductsData()
    {
        $productsInCart = Cart::getProducts();
        $productsData = array();
        //if cart not empty getting products data
        if ($productsInCart) {
            //getting array of products ids (ids from in_stock table )
            $productsIds = array_keys($productsInCart);
            $productsData = (new ProductsModel)->getProdustsDitailsByIds($productsIds);
        }
        return $productsData;
    }
    /**
     * Action for add to cart(using Ajax)
     */
    public function addAjaxAction()
    {
        if (Cart::checkLoged()) {
            //convert to int
            $productId = intval($this->route['id']);
            $amount = intval($this->route['amount']);
            $color = $this->route['color'];
            $size = $this->route['size'];
            echo ' (' . $this->addProduct($productId, $amount, $color, $size) . ')'; # quantity of products after adding
        } else
            echo "(0) <script>window.alert('Plese log-in to add product to your cart')</script>";
    }
    /**
     * Action for increase quantity of rpoduct cart(using Ajax)
     */
    public function incAjaxAction()
    {
        $productsData = $this->getProductsData();
        $id = intval($this->route['id']);
        $_SESSION['products'][$id]++;
        $this->model->updateCartDb($id,  $_SESSION['userName'], $_SESSION['products'][$id]);
        echo ' ' . Cart::quatityChangeRet($productsData) . ' ';
    }
    /**
     * Action for decrease quantity of rpoduct cart(using Ajax)
     */
    public function decAjaxAction()
    {
        $productsData = $this->getProductsData();
        $id = intval($this->route['id']);  #inStock id
        $_SESSION['products'][$id]--;
        $this->model->updateCartDb($id,  $_SESSION['userName'], $_SESSION['products'][$id]);
        echo ' ' . Cart::quatityChangeRet($productsData) . ' ';
    }

    /**
     * Action to delete product from cart
     */
    public function deleteAction()
    {
        Cart::deleteProduct($this->route['id']);
        $this->model->deleteProductFromCart(intval($this->route['id']), $_SESSION['userName']);
        $this->view->redirect("/SafeRideStore/cart");
    }
    /**
     * Function checks if product in stock 
     * @return int 
     */
    private function addProduct($productId, $quantity, $color, $size)
    {
        //gets id and quantity of product in stock
        $inStock = $this->model->ProductInStock($productId,  $color, $size);
        if ($inStock != null && $inStock['amount'] > 0) {
            $productsInCart = array();
            // check if there if products in cart (session)
            if (isset($_SESSION['products'])) {
                $productsInCart = $_SESSION['products'];
            }
            // check if this product in already in cart
            if (array_key_exists($inStock['inStockId'], $productsInCart)) {
                $productsInCart[$inStock['inStockId']] += $quantity;
                $_SESSION['products'] = $productsInCart;
                $this->model->updateCartDb($inStock['inStockId'],  $_SESSION['userName'],  $productsInCart[$inStock['inStockId']]);
            } else {
                $productsInCart[$inStock['inStockId']] = $quantity;
                $_SESSION['products'] = $productsInCart;
                $this->model->addProductTocartDb($inStock['inStockId'],  $_SESSION['userName'], $productsInCart[$inStock['inStockId']]);
            }

            echo "<script>window.alert('product added to cart')</script>";
        } else
            echo "<script>window.alert('SORRY,this product out of stock')  </script>";
        return Cart::countItems();
    }
    public function  totalAction()
    {
        echo Cart::totalPrice();
    }
}
