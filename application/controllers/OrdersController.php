<?php

namespace application\controllers;

use application\core\Controller;
use application\components\Cart;
/**
 * Orders  Controller 
 * Includes functions for work with orders
 */
class OrdersController extends Controller
{        
    /**
     * Action for orders history page
     */
    public function orderHistoryAction()
    {
        $vars['orders'] = $this->model->getOrdersByUserName($_SESSION['userName']);
        $this->view->render('My Orders', $vars);
    }    
    /**
     * Action for ordrer details
     * using Ajax
     */
    public function orderProductsAction()
    {
        $id = intval($this->route['id']);
        $productsIds = $this->model->productsInOrder($id);
        $products = $this->model->getOrderProdustsByIds($productsIds);

        echo $this->prepareProductsInOrder($products);
    }
    
    /**
     * prepare tabele with products details
     *
     * @param  array $products 
     * @return string (string for html) tabele of product details
     */
    public function prepareProductsInOrder($products)
    {
        $str = "";
        foreach ($products as $product) {
            $str .=
                "<tr>
                <td>" . $product['productId'] . "</td>
                <td>" . $product['inStockId'] . "</td>
                <td>" . $product['productName'] . "</td>
                <td>" . $product['color'] . "</td>
                <td>" . $product['size'] . "</td>
                <td>$" . $product['price'] . "</td>
                <td>" . $product['quantity'] . "</td>
            </tr>";
        }
        return $str;
    }    
    /**
     * Action for proceed ordrer 
     * using Ajax
     */
    public function  proceedOrderAction()
    {
        $massage = "Right now, we don't have those products in a given quanity:\n";
        $flag = true;
        //check if cart not empty
        if (!empty($_SESSION['products']))
            $i = 1;
            //check each product availability
        foreach ($_SESSION['products'] as $id => $quantity) {
            $result = $this->model->productAvailability($id, $quantity);
            if (!$result) {
                $massage .= $i++ . ")." . $this->model->getProductName($id) . "\n";
                $flag = false;
            }
        }
        if ($flag)
            echo "";
        else
            echo $massage;
    }
}
