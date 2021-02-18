<?php

namespace application\models;

use application\core\Model;

/**
 * AdminModel  this class includes funcions that extracts data related to admin panel from data base
 */
class AdminModel extends Model
{    
    /**
     * this function counts amount of sales for passed month and year
     *
     * @param  mixed $month
     * @param  mixed $year
     * @return int amount of sales
     */
    public function getSalesBymonth($month, $year)
    {
        return  $this->db->column("SELECT SUM(totalAmount) AS monthSalesAmount FROM orders WHERE MONTH(orderDate) = :monthTofind AND YEAR(orderDate) = :yearTofind", ["monthTofind" => $month, "yearTofind" => $year]);
    }    
    /**
     * this function counts amount of customerd joind for passed month and year
     *
     * @param  mixed $month
     * @param  mixed $year
     * @return int amount of customerd joind 
     */
    public function getCustomersBymonth($month, $year)
    {
        return  $this->db->column("SELECT count(*) AS NumberOfCustomers FROM customers WHERE MONTH(addedAt) = :monthTofind AND YEAR(addedAt) = :yearTofind AND role != 'admin'", ["monthTofind" => $month, "yearTofind" => $year]);
    }    
    /**
     * this function extracts from data base all the brands 
     *
     * @return array brand
     */
    public function getBrands()
    {
        return  $this->db->row("SELECT DISTINCT brand FROM products");
    }    
    /**
     * this function extracts from data base array with product names and ids
     *
     * @return array with product names and ids
     */
    public function getProductsIds()
    {
        return $this->db->row("SELECT productName,productId FROM  products");
    }    
    /**
     * this function adds discount to products with passed category
     *
     * @param  mixed $category
     * @param  mixed $discount
     * @param  mixed $percdent
     */
    public function addDiscountByCategory($category, $discount, $percdent)
    {
        $result = $this->db->array("SELECT productId FROM  products WHERE category=:category", ["category" => $category]);
        $this->updateDiscountLoop($result, $discount, $percdent);
    }
    /**
     * this function adds discount to products with passed brand
     *
     * @param  mixed $category
     * @param  mixed $discount
     * @param  mixed $percdent
     */
    public function addDiscountByBrand($brand, $discount, $percdent)
    {
        $result = $this->db->array("SELECT productId FROM  products WHERE brand=:brand", ["brand" => $brand]);
        $this->updateDiscountLoop($result, $discount, $percdent);
    }
/**
     * this function adds discount to passed products
     *
     * @param  mixed $category
     * @param  mixed $discount
     * @param  mixed $percdent
     */
    public function addDiscountProducts($products, $discount, $percdent)
    {
        $this->updateDiscountLoop($products, $discount, $percdent);
    }
    public function updateDiscountLoop($products, $discount, $percdent)
    {
        for ($i = 0; $i < count($products); $i++) {
            if (!$percdent) {
                $price = $this->db->column("SELECT price FROM  products WHERE productId=:productId", ["productId" => $products[$i]]);
                $percentDiscount = $this->getPercentDiscount($price, $discount);
                $this->updateDiscounts($percentDiscount, $products[$i]);
            } else
                $this->updateDiscounts($discount, $products[$i]);
        }
    }
    
    /**
     * this function calculates discount percent
     *
     * @param  mixed $price
     * @param  mixed $dicount
     * @return float  discount percent
     */
    private function getPercentDiscount($price, $dicount)
    {
        return $dicount * 100 / $price;
    }    
    /**
     * this function updates discount for product with passed id
     *
     * @param  mixed $discount
     * @param  mixed $id
     */
    public function updateDiscounts($discount, $id)
    {
        $this->db->query("UPDATE products SET discount = :discount  WHERE productId=:productId", ["discount" => $discount, "productId" => $id]);
    }    
    
    /**
     * this function remove discount for product with passed id
     *
     * @param  mixed $id
     */
    public function removeDiscount($id)
    {
        $this->db->query("UPDATE products SET discount = 0  WHERE productId=:productId", ["productId" => $id]);
    }
}
