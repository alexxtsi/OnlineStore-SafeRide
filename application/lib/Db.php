<?php

namespace application\lib;

use PDO;

/**
 * DB class connects to data base and allows you to build and execute database queries and fetch the result.
 **/
class Db
{
    protected $host;
    protected $db;
    protected $charset;
    protected $user;
    protected $password;
    protected $opt = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    protected $connection;

    public function __construct()
    {
        $config = require 'application/config/db.php';

        $this->host = $config['host'];
        $this->db = $config['db'];
        $this->charset = $config['charset'];
        $this->user = $config['user'];
        $this->password = $config['password'];
    }
    /**
     * this function  connects to data base
     */
    protected function connect()
    {
        $dns = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $this->connection = new PDO($dns, $this->user, $this->password, $this->opt);
    }
    /**
     * this function  disconnects to data base
     */
    public function disconnect()
    {
        $this->connection = null;
    }
        
    /**
     * this function prepare passed sql query and parameters fot this qiry then execute this query
     *
     * @param  string $sql sql query to execute
     * @param  array  $params parameters for getten query
     * @return mixed result statement
     */
    public function query($sql, $params = [])
    {
        $this->connect();
        $stmt = $this->connection->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':' . $key, $val);
            }
        }
        $stmt->execute();
        $this->disconnect();
        return $stmt;
    }
    
    /**
     * this function execute gatten query and return result
     *
     * @param  string $sql sql query to execute
     * @param  array  $params parameters for getten query
     * @return mixed array indexed by column name as returned in result set
     */
    public function row($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
/**
     * this function execute gatten query and return result
     *
     * @param  string $sql sql query to execute
     * @param  array  $params parameters for getten query
     * @return mixed  single column from the next row of a result set
     */
    public function column($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }
    /**
     * this function execute gatten query and return result
     *
     * @param  string $sql sql query to execute
     * @param  array  $params parameters for getten query
     * @return mixed  column from the next row of a result set
     */
    public function array($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchall(PDO::FETCH_COLUMN);
    }
    /**
     * this function execute gatten query and return result
     *
     * @param  string $sql sql query to execute
     * @param  array  $params parameters for getten query
     * @return mixed array filed by Products
     */
    public function fetchProduct($sql, $params = [])
    {
        $statement = $this->query($sql, $params);
        $products = array();
        while ($row =  $statement->fetchObject('application\components\Product'))
            $products[] = $row;
        return $products;
    }
}
