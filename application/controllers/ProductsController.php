<?php

namespace application\controllers;

use application\core\Controller;
use application\components\Product;

class ProductsController extends Controller
{

    public function productByCategoryAction()
    {
        $category = $this->route['category'];
        $vars['products'] = $this->model->getProductsByCategory($category);
        $this->view->render('Riding Gear', $vars);
    }
    public function productBySubCategoryAction()
    {
        $category = $this->route['category'];
        $vars['products'] = $this->model->getProductsBySubCategory($category);
        $this->view->render('Riding Gear', $vars);
    }

    public function productDetailsAction()
    {
        $vars['controller'] = $this;
        $vars['productId'] = $this->route['id'];
        $this->view->render('Riding Gear', $vars);
    }
    public function getArrayOfproducts(): array
    {
        $products = $this->model->getByCategory('helmet', $this->route['action']);
        return $products;
    }
    public function getProductById($id): Product
    {
        $product = $this->model->getById($id);
        return $product;
    }
  
}
