<?php

namespace application\controllers;

use application\core\Controller;
use application\components\Customer;

/**
 * Account Controller 
 * Includes functions for work with users ,action on their accounts such as:
 *  registretion,login,logout,edit acccount etc.
 */

class AccountController extends Controller
{
    /**
     * action for regictration page
     */
    public function registerAction()
    {
        if (empty($_POST) === false) {
            if (isset($_POST['register'])) {
                //check if customer with entered  user name or emalil exists in data base
                $massage = $this->checkIfExists($_POST['userName'], $_POST['email']);
                if ($massage != "")
                    $this->regMassage($massage);
                else {
                    $cst = $this->customerCreate();
                    $this->register($cst);
                }
            }
        }
        $this->view->render('Register');
    }
    
    /**
     * action for edit Account page
     */
    public function editAccountAction()
    {
        $cst = $this->model->getByUserName($_SESSION['userName']); #current customer data
        if (empty($_POST) === false) {
            if (isset($_POST['update'])) {
                $massage = "";
                $currentUserName = $cst->getuserName();
                //check if customer with entered  user name or emalil exists in data base
                if ($currentUserName != $_POST['userName'])
                    $massage = $this->checkIfExists($_POST['userName'], "");
                if (!$massage)
                    if ($cst->getemail() != $_POST['email'])
                        $massage = $this->checkIfExists("", $_POST['email']);
                if ($massage != "")
                    $this->regMassage($massage);
                else {
                    $cst = $this->customerCreate();
                    $this->update($cst, $currentUserName);
                    $_SESSION['userName'] = $_POST['userName'];
                }
            }
        }
        $vars['update'] = "";
        $vars['customer']  = $cst;
        $this->view->render('edit profile', $vars);
    }

    /**
     * action for log-in
     */
    public function LoginAction()
    {
        //if customer verified
        if (empty($msg = $this->customerVerify($_POST['userName'], $_POST['password']))) {
            $_SESSION['fullName'] = $this->getFullName($_POST['userName']);
            $_SESSION['userName'] = $_POST['userName'];
            $_SESSION['products'] = $this->model->loadCart($_SESSION['userName']);
            //if loged user is an admin
            if ($this->checkAdmin($_POST['userName']))
            $this->view->redirect("/SafeRideStore/admin");
            else
            $this->view->redirect("/SafeRideStore");
        }
        $vars['msg'] = $msg;
        $this->view->render('Login', $vars);
    }
    /**
     * action for logOut (unsets session)
     */
    public function logoutAction()
    {
        session_unset();
        $this->view->redirect("/SafeRideStore");
    }
    /**
     * action for password changing
     */
    public function changeAction()
    {
        $massage = array();
        $massage['success'] = "";
        $massage['verify'] = $this->customerVerify($_SESSION['userName'],  $_POST['currentPass']);
        if (!$massage['verify']) {
            $massage['confirm'] = $this->checkConfirm($_POST['newPass'], $_POST['confirmPass']);
            if (!$massage['confirm']) {
                $this->model->chagePass($_SESSION['userName'], password_hash($_POST['newPass'], PASSWORD_DEFAULT));
                $massage['success'] = "Your password has been changed";
            }
        }
        echo json_encode($massage);
    }    
    /**
     * checkConfirm
     *
     * @param  $newPass new password
     * @param  $confPass pasword confirmation 
     * @return string empty string if password confirmed else return relevant massage
     */
    public function checkConfirm($newPass, $confPass)
    {
        if ($newPass !== $confPass)
            return "The password confiration doesn't mach.";
        return "";
    }    
    /**
     * Action for contact page
     */
    public function contactAction()
    {
        $this->view->render('Contact Us');
    }
    public function massageAction()
    {
        $to  = 'alextsi037@gmail.com';
        $subject = "contact us form";
        $message = $_POST['message'];
        $headers  = 'Content-type: text/html; charset=windows-1251 \r\n';
        $headers .= 'From:' . $_POST['email'] . '\r\n';
        $headers .= 'Reply-To: reply-to@' . $_POST['email'] . '\r\n';
        mail($to, $subject, $message, $headers);
        $this->view->render('Contact Us');
    }
    /**
     * add cuctomer to DB
     * @param Customer $cst customer to add
     */
    public function register(Customer $cst)
    {
        $this->model->addCustomer($cst);
    }
    public function update($cst, $currentUserName)
    {
        $this->model->updateCustomer($cst, $currentUserName);
    }
    /**
     * check if cusromer with passed userName or email exist in DB
     * @param string $userName username to check
     * @param string $email email to check
     * @return string empty string if customer dosen't exist else relevant massage
     */
    public function checkIfExists($userName, $email)
    {
        $emailChk = $this->model->getByEmail($email);
        $userNameChk = $this->model->getByUserName($userName);
        $massage = "";
        if ($emailChk)
            $massage = "user with this email already exists";
        if ($userNameChk)
            if ($massage != "")
                $massage = "user with this email and this user name already exists";
            else
                $massage = "user with this user name already exists";
        return $massage;
    }
    /**
     * function adds java script alert with registretion massage 
     * @param string $massage massage for alert
     */
    public function regMassage($massage)
    {
        echo "<script type='text/javascript'>alert('$massage');</script>";
    }
    /**
     * function creats new entity for customer from $_POST arrat data
     * @return Customer $cst creates entity for customer
     */
    public function customerCreate(): Customer
    {
        $cst = new Customer();
        $cst->setfirstName($_POST['firstName']);
        $cst->setlastName($_POST['lasttName']);
        $cst->setEmail($_POST['email']);
        $cst->setuserName($_POST['userName']);
        $cst->setAddress($_POST['address']);
        $cst->setzipCode($_POST['zip']);
        $cst->setcity($_POST['city']);
        $cst->setPhoneNumber($_POST['phoneNumber']);
        if (isset($_POST['password'])) {
            $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $cst->setPassword($pass);
        }
        return $cst;
    }
    /**
     * get customer password from data base and verify with entered passwor
     *
     * @param  mixed $userName user name 
     * @param  mixed $passTocheck password to check
     * @return string empty string if verified else return relevant massage   
     */
    public function customerVerify($userName, $passTocheck)
    {
        //get customer passwor if he exists in data base if  not get null
        $password = $this->model->getPaswordByUserName($userName);
        if ($password)
            //if the customer verified save the full name to ssesion and redirect to main page
            if (password_verify($passTocheck, $password)) {

                return "";
            } else
                return "Wrong password";
        else
            return "There is no customer whith this User Name";
    }
   
    /**
     * function gets cusromers full name by passed username
     * @param string $userName userName of cusromer to get full name
     * @return string $fullName customers full name
     */
    public function getFullName($userName)
    {
        $fullNameArray = $this->model->getFullName($userName);
        $fullName = $fullNameArray[0]['firstName'] . " " . $fullNameArray[0]['lastName'];
        return $fullName;
    }

    /**
     * function to check if user andim or not
     * @param string $userName userName to check
     * @return boolean true for admin else false
     */
    private function checkAdmin($userName)
    {
        $result =  $this->model->checkRole($userName);
        if ($result === 'admin')
            return $_SESSION['admin'] = true;
        return false;
    }
}
