<?php

namespace application\models;

use application\core\Model;


/**
 * OrdersModel this class includes funcions that extracts data related to orders data from data base
 */
class OrdersModel extends Model
{
    /**
     * Function gets all Orders from Data Base.
     * @return array $orders All Order`s information.
     */
    public function getOrders()
    {
        $statement = $this->db->query("SELECT * FROM  orders");
        $orders = array();
        while ($row =  $statement->fetchObject('application\components\Order'))
            $orders[] = $row;
        return $orders;
    }
    /** 
     * Function gets all orders between specific Dates from Data Base . 
     * 
     * @param string $sDate Start Date for search.
     * @param string $eDate End Date for search.
     * @return array $orders All Orders information between specific Dates.
     */
    public function getOrdersByDate($sDate, $eDate)
    {
        $statement = $this->db->query("SELECT * FROM  orders WHERE  orderDate >= :startDate and orderDate<= STR_TO_DATE(:endDate, '%Y-%m-%d %H:%i:%s')  ", ['startDate' => $sDate, 'endDate' => $eDate]);
        $orders = array();
        while ($row =  $statement->fetchObject('application\components\Order'))
            $orders[] = $row;
        return $orders;
    }
    /**
     * Function gets customers Orders from Data Base.
     * 
     * @param string $userName User Name of Customer.
     * @return array $orders All Orders information of specific customer.
     */
    public function getOrdersByUserName($userName)
    {
        $statement = $this->db->query("SELECT * FROM  orders WHERE userName=:userName  ", ['userName' => $userName]);
        $orders = array();
        while ($row =  $statement->fetchObject('application\components\Order'))
            $orders[] = $row;
        return $orders;
    }
    /**
     * this function extracts order with passed id from data base
     *
     * @param  mixed $id
     * @return Order relevanr order 
     */
    public function getOrderById($id)
    {
        $statement = $this->db->query("SELECT * FROM  orders WHERE orderId=:orderId", ["orderId" => $id]);
        return $statement->fetchObject('application\components\Order');
    }
    /**
     * this function extracts from data base products that appaears in order with passed id 
     *
     * @param  mixed $id
     * @return array array full of products
     */
    public function productsInOrder($id)
    {
        $result = $this->db->row("SELECT inStockId FROM  products_in_order WHERE orderId=:orderId", ["orderId" => $id]);
        for ($i = 0; $i < count($result); $i++) {
            $result[$i] = intval($result[$i]['inStockId']);
        }
        return $result;
    }

    /**
     * this function extracts from data base products data of products with passed ids
     *
     * @param  array  $productsIds array with product ids
     * @return array araay with products data
     */
    public function getOrderProdustsByIds($productsIds)
    {
        $productsIds = $this->prapere($productsIds);
        $placeholders = $productsIds['placeholders'];
        unset($productsIds['placeholders']);
        return $this->db->row("SELECT products.productId,in_stock.inStockId,in_stock.size, in_stock.color,products.productName,products.price,products.category,products.imgPath,products.brand,products_in_order.quantity
                                  FROM in_stock 
                                  INNER JOIN products_in_order ON in_stock.inStockId = products_in_order.inStockId 
                                  INNER JOIN products ON in_stock.productId = products.productId 
                                  AND in_stock.inStockId IN ($placeholders)", $productsIds);
    }
    /**
     * this function extracts from data base customer data of customer who made the order with passed id
     *
     * @param  mixed $id
     * @return Customer relevant customer data
     */
    public function getCustomerByOrder($id)
    {
        $statement = $this->db->query("SELECT * FROM  customers WHERE userName=(SELECT userName FROM orders WHERE orderId=:orderId)", ["orderId" => $id]);
        return $statement->fetchObject('application\components\Customer');
    }
    /**
     * this function checks if product availibale in stock
     *
     * @param  int $id producy id
     * @param  int $quantity needed quanity
     * @return int 1 - availible 0 - not available
     */
    public function productAvailability($id, $quantity)
    {
        $result = $this->db->row("SELECT amount ,
                                    CASE WHEN amount >= :quantity THEN 1
                                    ELSE 0
                                    END AS Availability
                                    FROM in_stock WHERE inStockId =:inStockId", ["inStockId" => $id, "quantity" => $quantity]);
        return $result[0]['Availability'];
    }
    /**
     * this function extracts from data base product name by instock id
     *
     * @param  int $id instovk id
     * @return string product name
     */
    public function getProductName($id)
    {
        return $this->db->column("SELECT products.productName 
                                   FROM  in_stock 
                                   INNER JOIN products ON in_stock.productId = products.productId 
                                   WHERE inStockId=:inStockId ", ["inStockId" => $id]);
    }
    public function changeOrderStatus($status, $id)
    {
        $this->db->query("UPDATE orders SET orderStatus = :orderStatus  WHERE orderId=:orderId", ["orderStatus" => $status, "orderId" => $id]);
    }
}
