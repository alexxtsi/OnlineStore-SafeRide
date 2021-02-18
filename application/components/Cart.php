<?php

/**
 * Class Cart
 * includes static function for work with cart 
 */

namespace application\components;

use application\lib\Db;
use application\models\AdminModel;
use application\models\CartModel;

abstract class Cart
{


    /**
     * this function counts products in cart    

     * @return int $count number of products in cart
     */
    public static function countItems()
    {
        //check if there is products in session
        if (isset($_SESSION['products'])) {
            //count how many products in session
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
    /**
     * this function gets array of products in cart from session
     *
     * @return array of products in cart if there is no products return false
     */
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

    /**
     * this function returns total price of products in cart   
     *
     * @return float total price of products in cart 
     */
    public static function totalPrice()
    {
        return (new CartModel)->getCartTotal($_SESSION['userName']);
    }
    /**
     * this function calculates price without vat
     *      
     * @return int price without vat
     */
    public static function priceNoVat()
    {
        $vat = self::getVat();
        $total = self::totalPrice();

        return round(($total / (1 + $vat)), 2);
    }
    /**
     * this function check if user logged in 
     *
     * @return boolean true for logged else return false
     */
    public static function checkLoged()
    {
        if (isset($_SESSION['fullName']))
            return true;
        return false;
    }
    /**
     * this function gets curren vat vaue
     *
     * @return float current vat value
     */
    public static function getVat()
    {
        return (new Db)->column("SELECT vat FROM tax") / 100;
    }
    /**
     * his function sets curren vat vaue
     *
     * @param  float  $value new vat value
     */
    public static function setVat($value)
    {
        return (new Db)->query("UPDATE tax SET vat=:vat", ["vat" => $value]);
    }
    /**
     * this fanction calculate price with vat for current cart total
     *
     * @return float price with vat for current cart total
     */
    public static function calVat()
    {
        return (round(self::priceNoVat() * self::getVat(), 2));
    }
    /**
     * this function prapere and return string with current cart price data
     *
     * @return string current cart price data
     */
    public static function quatityChangeRet()
    {
        $subTotal = self::priceNoVat();
        $output = array(
            'totalPrice' => self::TotalPrice(),
            'subTotal'  => $subTotal,
            'vat' => self::calVat(),
            'totalItems'  => self::countItems()
        );
        return json_encode($output);
    }
    /**
     * this function calculate product rice after discount
     *
     * @param  mixed $discount discount value
     * @param  mixed $price current price
     * @return float price after discount
     */
    public static function calDiscount($discount, $price)
    {
        return $price - round($discount * $price / 100);
    }
}
