<?php

namespace application\models;

use application\core\Model;


class AccountModel extends Model
{

    //find customer in bata base and return  by user name
    public function getByUsername($userName)
    {
        $statement = $this->db->query("SELECT * FROM customers WHERE userName=:userName", ["userName" => $userName]);
        $customer =  $statement->fetchObject('application\classes\Customer');
        return $customer;
    }

    //find and return customer by email
    public function getByEmail($email)
    {
        $statement = $this->db->query("SELECT * FROM customers WHERE email=:email", ["email" => $email]);
        $customer =  $statement->fetchObject('application\classes\Customer');
        return $customer;
    }
    public function addCustomer($customer)
    {
        $this->db->query("INSERT INTO customers (firstName,lastName,email,userName,address,phoneNumber,password) VALUES (:firstName,:lastName,:email,:userName,:address,:phoneNumber,:password)", ["firstName" => $customer->getFirstName(), "lastName" => $customer->getLastName(), "email"  => $customer->getEmail(), "userName"  => $customer->getUserName(), "address" => $customer->getAddress(), "phoneNumber" => $customer->getPhoneNumber(), "password" => $customer->getPassword()]);
    }

    public function getPaswordByUserName($userName)
    {
        $password = $this->db->column("SELECT password FROM customers WHERE userName=:userName", ["userName" => $userName]);
        return $password;
    }
    public function getFullName($userName)
    {
        $row = $this->db->row("SELECT firstName,lastName FROM customers WHERE userName=:userName", ["userName" => $userName]);
        return $row;
    }
    public function getAllCustomers()
    {
        $statement = $this->db->query("SELECT * FROM customers");
        $customers = array();
        while ($row =  $statement->fetchObject('application\components\Customer'))
            $customers[] = $row;
        return $customers;
    }
}
