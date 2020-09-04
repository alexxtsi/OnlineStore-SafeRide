<?php

namespace application\controllers;

use application\core\Controller;

class AdminController extends Controller
{

    public function adminAction()
    {
        $this->view->render('Admin Dashboard', ['admin' => true]);
    }
    public function adminProductsAction()
    {
        //products model
        $vars['products'] = $this->model->getAllProducts();
        $vars['admin'] = "";
        $this->view->render('Admin products', $vars);
    }
    public function adminCustomersAction()
    {
        //customers model
        $vars['customers'] = $this->model->getAllCustomers();
        $vars['admin'] = "";
        $this->view->render('Admin customers', $vars);
    }
    public function adminProductEditAction()
    {
        $id = intval($this->route['id']);
        //products model
        $vars['product'] = $this->model->getById($id);
        $vars['admin'] = "";
        $this->view->render('Admin products Edit', $vars);
    }
}
