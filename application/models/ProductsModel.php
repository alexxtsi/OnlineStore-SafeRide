<?php

namespace application\models;

use application\components\Product;
use application\core\Model;
use PDO;

/**
 * ProductsModel this class includes funcions that extracts data related to products data from data base
 */
class ProductsModel extends Model
{
    /**
     * this function extracts products with passed sub category from data base 
     *
     * @param  string $subCategory
     * @return array array with relevant products 
     */
    public function getProductsBySubCategory($subCategory)
    {
        return  $this->db->fetchProduct("SELECT * FROM  products WHERE subCategory=:subCategory", ["subCategory" => $subCategory]);
    }
    /**
     *  this function extracts products with passed  category from data base 
     *
     * @param  string $category
     * @return array array with relevant products 
     */
    public function getProductsByCategory($category)
    {
        return  $this->db->fetchProduct("SELECT * FROM  products WHERE category=:category", ["category" => $category]);
    }
    /**
     *  this function extracts products with passed  category and brand  from data base 
     *
     * @param  string $category
     * @param  string $brand
     * @return array array with relevant products 
     */
    public function getProductsByCategoryAndBrand($category, $brand)
    {
        return  $this->db->fetchProduct("SELECT * FROM  products WHERE (category=:category OR subCategory=:category) AND brand=:brand ", ["category" => $category, "brand" => $brand]);
    }
    /**
     *  this function extracts product with passed  id from data base 
     *
     * @param int $id product id to search
     * @return Product product with passed id
     */
    public function getById($id)
    {
        $statement = $this->db->query("SELECT * FROM  products WHERE productId=:productId ", ["productId" => $id]);
        $product =  $statement->fetchObject('application\components\Product');
        return $product;
    }
    /**
     *  this function extracts product  from data base by passed value
     *
     * @param  string $value the value can be product name ,brand ,category or sub category
     * @return Product relevat product
     */
    public function getProductsBySearch($value)
    {
        return  $this->db->fetchProduct("SELECT * FROM  products WHERE productName LIKE :value OR brand LIKE :value OR  subCategory LIKE :value OR category LIKE :value", ["value" => '%' . $value . '%']);
    }

    /**
     * this function extracts all the products that apears in data base
     *
     * @return array array that includes all the product that apears in data base
     */
    public function getAllProducts()
    {
        return  $this->db->fetchProduct("SELECT * FROM  products");
    }

    /**
     * this function extracts specific product data from products and in_stock tables 
     *
     * @param  array  array that includes in stock ids
     * @return array product data for products with in stock ids from passed array product data
     */
    public function getProdustsDitailsByIds($productsIds)
    {
        $productsIds = $this->prapere($productsIds);
        $placeholders = $productsIds['placeholders'];
        unset($productsIds['placeholders']);
        return  $this->db->row("SELECT in_stock.inStockId,in_stock.size, in_stock.color,products.productName,products.price,products.category,products.imgPath,products.brand,products.discount
                                  FROM in_stock 
                                  INNER JOIN products ON in_stock.productId = products.productId AND inStockId IN ($placeholders)", $productsIds);
    }
    /**
     * this function extracts instock data for product with passed id from in_stock table
     *
     * @param  int $id id to search
     * @return array  in stock data for product with passed id
     */
    public function getInstockByProductId($id)
    {
        return $this->db->row("SELECT inStockId,size,color,amount FROM  in_stock WHERE productId=:productId ", ["productId" => $id]);
    }
    /**
     * this function inserts product stock to data base
     *
     * @param  int $id
     * @param  string $size
     * @param  string $color
     * @param  string $amount
     * @return int in stock id for inserted product stock
     */
    public function addToStock($id, $size, $color, $amount)
    {
        $this->db->query(
            "INSERT INTO in_stock (productId, size, color, amount) 
                 VALUES (:productId, :size, :color, :amount)",
            ["productId" => $id, "size" => $size, "color" => $color, "amount" => $amount]
        );
        $result = $this->db->row("SELECT inStockId FROM in_stock WHERE productId=:productId And color=:color AND size=:size", ["productId" => $id, "color" => $color, "size" => $size]);
        return  $result[0];
    }
    /**
     * this function updates product stock to data base
     *
     * @param  mixed $id
     * @param  mixed $size
     * @param  mixed $color
     * @param  mixed $amount
     * @return array inStockId and amount of updated product
     */
    public function updateStock($id, $size, $color, $amount)
    {
        $this->db->query(
            "UPDATE in_stock
           SET amount = amount + :amount
          WHERE productId=:productId AND size=:size AND color=:color",
            ["productId" => $id, "size" => $size, "color" => $color, "amount" => $amount]
        );
        $result = $this->db->row("SELECT inStockId,amount FROM in_stock WHERE productId=:productId And color=:color AND size=:size", ["productId" => $id, "color" => $color, "size" => $size]);
        if ($result) #if result returned there is only one row 
            return  $result[0];
        return null;
    }
    /**
     * this function updates product stock quantity 
     *
     * @param  mixed $id
     * @param  mixed $amount
     */
    public function updateStockById($id, $amount)
    {
        $this->db->query("UPDATE in_stock SET amount = :amount  WHERE inStockId=:inStockId", ["inStockId" => $id, "amount" => $amount]);
    }
    /**
     * this function deletes product stock from data base
     *
     * @param  mixed $id
     */
    public function deleteStockById($id)
    {
        $this->db->query("DELETE FROM in_stock WHERE inStockId=:inStockId", ["inStockId" => $id]);
    }
    /**
     * this function check if product stock with passed parameters exists
     *
     * @param  mixed $id
     * @param  mixed $size
     * @param  mixed $color
     * @return bollean true if exists fale dosen't exists
     */
    public function isStockExists($id, $size, $color)
    {
        $resulat = $this->db->column(
            "SELECT COUNT(*) FROM  in_stock 
             WHERE  productId=:productId AND size=:size AND color=:color",
            ["productId" => $id, "size" => $size, "color" => $color]
        );
        $resulat = intval($resulat);
        if ($resulat > 0)
            return true;
        return false;
    }
    /**
     * this function extracts available colors for product with passed id
     * @param  int $id
     * @return array array of colors
     */
    public function getAvailableColors($id)
    {
        $colors = array();
        $result = $this->db->row("SELECT DISTINCT color FROM in_stock WHERE productId=:productId", ["productId" => $id]);
        for ($i = 0; $i < count($result); $i++) {
            $colors[$i] = $result[$i]['color'];
        }
        return $colors;
    }
    /**
     * this function extracts available sizes for product with passed id and color
     *
     * @param  mixed $id
     * @param  mixed $color
     * @return array  array of sizes
     */
    public function getAvailableSizes($id, $color)
    {
        $sizes = array();
        $result = $this->db->row("SELECT DISTINCT size FROM in_stock WHERE productId=:productId AND color=:color", ["productId" => $id, "color" => $color]);
        for ($i = 0; $i < count($result); $i++) {
            $sizes[$i] = $result[$i]['size'];
        }
        return $sizes;
    }

    /**
     * this function add passed product to data base
     *
     * @param  Product $product
     */
    public function addProduct($product)
    {

        $this->db->query(
            "INSERT INTO products(productId, productName,category,subCategory,price,imgPath,brand) 
                 VALUES (:productId, :productName,:category,:subCategory,:price,:imgPath,:brand)",
            [
                "productId" => $product->getProductId(), "productName" => $product->getProductName(), "category" => $product->getCategory(),
                "subCategory" => $product->getSubCategory(), "price" => $product->getPrice(), "imgPath"  => $product->getImgPath(),
                "brand" => $product->getBrand()
            ]
        );
    }

    /**
     * this function updates passed product to data base
     *
     * @param  mixed $product
     * @param  mixed $idToUpdate current productd id
     */
    public function updateProduct($product, $idToUpdate)
    {
        return  $this->db->query(
            "UPDATE products
             SET productId=:productId,productName=:productName,category=:category,subCategory=:subCategory,price=:price,imgPath=:imgPath,brand=:brand 
             WHERE productId=:oldProdId",
            [
                "productId" => $product->getProductId(), "productName" => $product->getProductName(), "category" => $product->getCategory(),
                "subCategory" => $product->getSubCategory(), "price" => $product->getPrice(),  "imgPath"  => $product->getImgPath(),
                "brand" => $product->getBrand(), "oldProdId" => $idToUpdate
            ]
        );
    }
    /**
     * this function deletes product with passed id from data base
     *
     * @param  int $productId
     */
    public function deleteProduct($productId)
    {
        $this->db->query("DELETE FROM products WHERE productId=:productId", ["productId" => $productId]);
        $this->db->query("DELETE FROM in_stock WHERE productId=:productId", ["productId" => $productId]);
    }
    /**
     * this function check if product with passed id appears in data base
     *
     * @param  int $id
     * @return int 0 product dosen't exists elese product exists
     */
    public function checkId($id)
    {
        return $this->db->column("SELECT COUNT(*) FROM products WHERE productId=:productId ", ["productId" => $id]);
    }
    /**
     * this function extracts top 10 sellind products from data base
     *
     * @return array top 10 sellind products
     */
    public function getTopSelling()
    {
        $productsIds = $this->db->array("SELECT products.productId  FROM products 
                               INNER JOIN in_stock on in_stock.productId = products.productId 
                               INNER JOIN products_in_order on in_stock.inStockId = products_in_order.inStockId
                               GROUP BY products.productId
                               ORDER BY sum(products_in_order.quantity) DESC
                               LIMIT 10");
        return  $this->getProdustsByIds($productsIds);
    }
    /**
     *  this function extracts products with passed ids from data base 
     *
     * @param  array $productsIds
     * @return array array full of relevant products
     */
    public function getProdustsByIds($productsIds)
    {
        $productsIds = $this->prapere($productsIds);
        $placeholders = $productsIds['placeholders'];
        unset($productsIds['placeholders']);
        return  $this->db->fetchProduct("SELECT * FROM  products WHERE productId IN ($placeholders)", $productsIds);
    }

    /**
     * this function extracts from data base array with product with disscounts
     *
     * @return  array with product with disscounts
     */
    public function getDiscounts()
    {
        $statement = $this->db->query("SELECT * FROM  products  WHERE discount!=0");
        $products = array();
        while ($row =  $statement->fetchObject('application\components\Product'))
            $products[] = $row;
        return $products;
    }
}
