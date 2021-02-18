<?php

namespace application\controllers;

use application\core\Controller;
use application\components\Product;

/**
 * Products Controller 
 * Includes functions for work with Products such as :
 * adding ,deteting ,editing ect.
 */
class ProductsController extends Controller
{

    /**
     * Action for products page loaded by categry
     */
    public function productByCategoryAction()
    {
        $category = $this->route['category'];
        $vars['products'] = $this->model->getProductsByCategory($category);
        $this->view->render('Riding Gear', $vars);
    }
    /**
     * Action for products page loaded by sub categry
     */
    public function productBySubCategoryAction()
    {
        $category = $this->route['category'];
        $vars['products'] = $this->model->getProductsBySubCategory($category);
        $this->view->render('Riding Gear', $vars);
    }

    /**
     * Action for search
     */
    public function productSearchAction()
    {
        if (isset($_POST['submit-search']))
            $search = ($_POST["searching"]);
        $vars['products'] = $this->model->getProductsBySearch($search);
        $this->view->render('Search For You', $vars);
    }
    /**
     * Action for products page loaded by url path
     */
    public function productByUrlAction()
    {
        $search = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $words = explode('/', $search);
        $lastWord = array_pop($words);
        $vars['products'] = $this->model->getProductsBySearch($lastWord);
        $this->view->render('Riding Gear', $vars);
    }
    /**
     * Action for product details page 
     */
    public function productDetailsAction()
    {
        $vars['productId'] = $this->route['id'];
        $vars['product'] = $this->model->getById($vars['productId']);
        $vars['colors'] = $this->model->getAvailableColors($vars['productId']);
        $this->view->render('Riding Gear', $vars);
    }
    /**
     * Action for product sales page 
     */
    public function salesAction()
    {
        $vars['products'] = $this->model->getDiscounts();
        $this->view->render('sales', $vars);
    }
     /**
     * Action for banner links 
     */
    public function bannerAction()
    {
        $brand = $this->route['brand'];
        $category = $this->route['category'];
        $vars['products'] = $this->model->getProductsByCategoryAndBrand($category,$brand);
        $this->view->render('Riding Gear', $vars);
    }
    /**
     * Action to load available sizes for chosen color 
     */
    public function sizesAjaxAction()
    {
        $productId = intval($this->route['id']);
        $color = $this->route['color'];
        $sizes = array('small', 'medium', 'large');
        $sizesAvaileble = $this->model->getAvailableSizes($productId, $color);
        $output = '';
        for ($i = 0; $i < count($sizes); $i++) {
            $status = 'disabled';
            for ($j = 0; $j < count($sizesAvaileble); $j++) {
                if ($sizes[$i] == $sizesAvaileble[$j]) #if current size available for chosen color customer will be able to choose
                    $status = ' '; #enabled
            }
            $output .= '
                        <div class="form-check form-check-inline pl-0">
                        <input type="radio" class="form-check-input" value=' . $sizes[$i] . ' name="sizes"' .  $status . '  >
                        <label class="form-check-label small text-uppercase" for=' . $sizes[$i] . '>' . $sizes[$i] . '</label>
                        </div>';
        }
        echo $output;
    }
    /**
     * this function gets array of products
     *
     * @return array array of products
     */
    public function getArrayOfproducts(): array
    {
        $products = $this->model->getByCategory('helmet', $this->route['action']);
        return $products;
    }

}
