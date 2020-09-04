<?php

namespace application\models;

use application\core\Model;


class CartModel extends Model
{
    public function productInStock($id, $color, $size)
    {
        $result = $this->db->row("SELECT inStockId,amount FROM in_stock WHERE productId=:productId And color=:color AND size=:size", ["productId" => $id, "color" => $color, "size" => $size]);
        if ($result) #if result returned there is only one row 
            return  $result[0];
        return null;
    }
    public function getProdustsByIds($productsIds)
    {
        $productsIds = $this->prapere($productsIds);
        $placeholders = $productsIds['placeholders'];
        unset($productsIds['placeholders']);
        return  $this->db->row("SELECT in_stock.inStockId,in_stock.size, in_stock.color,products.productName,products.price,products.category,products.imgPath,products.brand
                                  FROM in_stock 
                                  INNER JOIN products ON in_stock.productId = products.productId AND inStockId IN ($placeholders)", $productsIds);
    }

    /**
     *This method prapere array of product ids for sql query
     * @return array productsIds 
     */
    private function prapere(array $productsIds)
    {
        $placeholders = "";
        $count = count($productsIds);
        for ($i = 0; $i < $count; $i++) {
            $placeholders .= ':id' . ($i + 1) . ',';
            $productsIds['id' . ($i + 1)] = $productsIds[$i];
            unset($productsIds[$i]);
        }

        //trim off the trailing comma and space
        $placeholders = rtrim($placeholders, ',');
        $productsIds['placeholders'] = $placeholders;
        return $productsIds;
    }
}
