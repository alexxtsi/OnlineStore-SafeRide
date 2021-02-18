<?php
namespace application\controllers;
/**
 * Main Controller 
 * Includes functions for main page
 */
use application\core\Controller;
use application\models\ProductsModel;

class MainController extends Controller
{
    /**
     * Action for main page
     */
    public function indexAction()
    {
        $this->model = new ProductsModel;
        $vars['products'] = $this->model->getTopSelling();
        $this->view->render('Main page', $vars);
    }
    public function guidAction()
    {
        $this->view->render('Gear Guid');
    }
}
