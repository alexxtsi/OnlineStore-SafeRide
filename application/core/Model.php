<?php

namespace application\core;

use application\lib\Db;
/**
 * Model abstract class 
 * the core for other Models 
 */
abstract class Model
{
    public $db;
    public function __construct()
    {
        $this->db = new Db;
    }
    /**
     *This method prepare array of product ids for sql query
     * @return array productsIds 
     */
    protected function prapere(array $productsIds)
    {
        $placeholders = "";
        $count = count($productsIds);
        for ($i = 0; $i < $count; $i++) {
            $placeholders .= ':id' . ($i + 1) . ',';
            $productsIds['id' . ($i + 1)] = $productsIds[$i];
            unset($productsIds[$i]);
        }
        $placeholders = rtrim($placeholders, ',');  # trim off the trailing comma
        $productsIds['placeholders'] = $placeholders;
        return $productsIds;
    }
}
