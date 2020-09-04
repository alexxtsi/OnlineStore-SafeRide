<?php

namespace application\controllers;

use application\core\Controller;
use application\classes\Customer;

class AccountController extends Controller
{

    public function registerAction()
    {
        $vars['controller'] = $this;
        $this->view->render('Register', $vars);
    }
    public function LoginAction()
    {
        $vars['controller'] = $this;
        $this->view->render('Login', $vars);
    }
    public function register($cst)
    {

        $this->model->addCustomer($cst);
    }
    public function checkIfExists($userName, $email)
    {
        $emailChk = $this->model->getByEmail($email);
        $userNameChk = $this->model->getByUserName($userName);
        $massage = "";
        if ($emailChk) #if customer with this email exists
            $massage = "user with this email already exists";
        if ($userNameChk)
            if ($massage != "")  #if customer with this user name and email exists
                $massage = "user with this email and this user name already exists";
            else   #if customer with this user name  exists
                $massage = "user with this user name already exists";
        return $massage;  #if customer with this email or user name dosent exits the massage is empty 

    }
    public function regMassage($massage)
    {
        echo "<script type='text/javascript'>alert('$massage');</script>";
    }

    public function customerCreate(): Customer
    {
        $cst = new Customer();
        $cst->setfirstName($_POST['firstName']);
        $cst->setlastName($_POST['lasttName']);
        $cst->setEmail($_POST['email']);
        $cst->setuserName($_POST['userName']);
        $cst->setAddress($_POST["address"] . ", " . $_POST["city"]);
        $cst->setPhoneNumber($_POST['phoneNumber']);
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $cst->setPassword($pass);
        return $cst;
    }
    //get customer password from data base and verify with entered passwor return empty sring if verified else return massage 
    public function customerVerify($userName)
    {
        //get customer passwor if he exists in data base if  not get null
        $password = $this->model->getPaswordByUserName($userName);
        if ($password)
            //if the customer verified save the full name to ssesion and redirect to main page
            if (password_verify($_POST['password'], $password))
                return "";
            else
                return "Wrong password";
        else
            return "There is no customer whith this User Name";
    }
    public function loadCustomerCart()
    {
    }
    public function getFullName($userName)
    {
        $fullNameArray = $this->model->getFullName($userName);
        $fullName = $fullNameArray[0]['firstName'] . " " . $fullNameArray[0]['lastName'];
        return $fullName;
    }
    public function logoutAction()
    {
        session_unset();
        header("Location: /SafeRideStore");
    }
}
