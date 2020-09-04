<?php

namespace application\models;

use application\components\Product;
use application\core\Model;


class ProductsModel extends Model
{
    //get subcategorty and return products of this category
    public function getProductsBySubCategory($subCategory)
    {
        $statement = $this->db->query("SELECT * FROM  products WHERE subCategory=:subCategory", ["subCategory" => $subCategory]);
        $products = array();
        while ($row =  $statement->fetchObject('application\components\Product'))
            $products[] = $row;
        return $products;
    }
    public function getProductsByCategory($category)
    {
        $statement = $this->db->query("SELECT * FROM  products WHERE category=:category", ["category" => $category]);
        $products = array();
        while ($row =  $statement->fetchObject('application\components\Product'))
            $products[] = $row;
        return $products;
    }
    public function getById($id): Product
    {
        $statement = $this->db->query("SELECT * FROM  products WHERE productId=:productId ", ["productId" => $id]);
        $product =  $statement->fetchObject('application\components\Product');
        return $product;
    }
    public function getAllProducts()
    {
        $statement = $this->db->query("SELECT * FROM  products");
        $products = array();
        while ($row =  $statement->fetchObject('application\components\Product'))
            $products[] = $row;
        return $products;
    }
}
