<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;
use application\components\Product;
use application\components\Cart;
use application\models\ProductsModel;

/**
 * Admin Controller 
 * Includes functions for work with administration panel such as:
 *  view statistic or mange products,orders,discounts,vat etc.
 */
class AdminController extends Controller
{
    /**
     * action for notify page
     */
    public function notifyAction()
    {
        require 'application/components/notify.php';
    }
    /**
     * action for discount page
     */
    public function discountAction()
    {
        $this->checkAdmin();
        if (isset($_POST['applyDiscount'])) {
            $this->addDiscount($_POST['discountValue']);
            $vars['massage'] = "<script>f$(document).ready(function() {
                alert('discount has been added')
              });</script>";
        }
        $vars = $this->loadDiscountVars();
        $this->view->render('discount', $vars);
    }
    /**
     * action for delete discount 
     */
    public function discountDeleteAction()
    {
        $this->checkAdmin();
        $this->model->removeDiscount($this->route['id']);
        $vars = $this->loadDiscountVars();
        $vars['massage'] = " <script>$(document).ready(function() {
                             alert('discount has been removed')
                            });</script>";

        $this->view->render('discount', $vars);
    }
    /**
     * action for change order status 
     */
    public function changeStatusAction()
    {
        $this->checkAdmin();
        $this->model->changeOrderStatus($_POST['status'], $_POST['id']);
    }
    /**
     * This function loads to vars array products with discounts,all existing products and all existing brands.
     *
     * @return array array with these variabels
     */
    public function loadDiscountVars()
    {
        $vars['productsDiscounts'] = $this->prepareDiscounts((new ProductsModel)->getDiscounts());
        $vars['products'] = $this->model->getProductsIds();
        $vars['brands'] = $this->model->getBrands();
        $vars['admin'] = "";
        return $vars;
    }
    /**
     * This functionj prepares table with data of discounted products
     *
     * @param  array array of products with discount
     * @return string (string for html) table with data of discounted products
     */
    public function prepareDiscounts($discounts)
    {
        $output = "";
        if (!empty($discounts))
            for ($i = 0; $i < count($discounts); $i++) {
                $output .= ' <tr>
            <td>' . $discounts[$i]->getProductId() . '</td>
            <td>' . $discounts[$i]->getProductName() . '</td>
            <td>' . $discounts[$i]->getCategory() . '</td>
            <td>' . $discounts[$i]->getBrand() . '</td>
            <td>' . $discounts[$i]->getPrice() . ' $</td>
            <td>' . $discounts[$i]->getDiscount() . ' %</td>
            <td >' . (round($discounts[$i]->getPrice() - ($discounts[$i]->getDiscount() * $discounts[$i]->getPrice() / 100))) . ' $</td>
            <td class="nav justify-content-start">
                <a class="mx-2 text-danger" title="Remove Discount" href="/SafeRideStore/admin/discount/delete/' . $discounts[$i]->getProductId() . '"><i class="fas fa-times"></i></a>
            </td>
            </tr>';
            }
        return $output;
    }

    /**
     * this function defines what if discount applies by category ,brand or for specific producs
     *  then adding discount to relevant products
     * @param  mixed $value discount value
     
     */
    public function addDiscount($value)
    {
        $percentType = $this->defineDiscountType();
        if ($_POST['choose'] == 'byCategory') {
            $this->model->addDiscountByCategory($_POST['category'], $value, $percentType);
        } else if ($_POST['choose'] == 'byBrand')
            $this->model->addDiscountByBrand($_POST['brand'], $value, $percentType);
        else
            $this->model->addDiscountProducts($_POST['products'], $value, $percentType);
    }
    /**
     * this function defines discount type precent or fixed amount id dollars
     *
     * @return bool true for precent ,false for fixed amount 
     */
    public function defineDiscountType()
    {
        if ($_POST['type'] == "amount")
            return false;
        return true;
    }

    /**
     * action for sales statistics page
     */
    public function salesStatisticsAction()
    {
        $this->checkAdmin();
        $this->view->render('Sales Statistics', ['admin' => true]);
    }

    /**
     * action for loading sales statstic
     */
    public function loadSalesAction()
    {
        $this->checkAdmin();
        $year = intval($this->route['id']);
        $sales = array();
        for ($i = 1; $i <= 12; $i++) {
            $sales["month" . $i] = $this->model->getSalesBymonth($i, $year);
            if ($sales["month" . $i] == null)
                $sales["month" . $i] = 0;
        }
        echo json_encode($sales);
    }

    /**
     * action for customers statistics page
     */
    public function customersStatisticsAction()
    {
        $this->checkAdmin();
        $this->view->render('Customers Statistics', ['admin' => true]);
    }
    /**
     * action for loading customers statstic
     */
    public function loadCustomersAction()
    {
        $this->checkAdmin();
        $year = intval($this->route['id']);
        $sales = array();
        for ($i = 1; $i <= 12; $i++) {
            $sales["month" . $i] = $this->model->getCustomersBymonth($i, $year);
            if ($sales["month" . $i] == null)
                $sales["month" . $i] = 0;
        }
        echo json_encode($sales);
    }
    /**
     * action for admin page
     */
    public function adminAction()
    {
        $this->checkAdmin();
        $this->view->render('Admin Dashboard', ['admin' => true]);
    }
    /**
     * action for admin Products page
     */
    public function adminProductsAction()
    {
        $this->checkAdmin();
        //products model
        $products = $this->model->getAllProducts();
        $vars['products'] = $this->praperProducts($products);
        $vars['admin'] = "";
        $this->view->render('Admin Products', $vars);
    }
    public function adminProductsFilterAction()
    {
        $this->checkAdmin();
        $filter = $_POST['filter'];
        //products model
        $products = $this->model->getProductsBySearch($filter);
        echo $this->praperProducts($products);
    }

    /**
     * this function prapers table of products
     *
     * @param  array $products array of products
     * @return string (string for html) table of products
     */
    public function praperProducts($products)
    {
        $output = "";
        if (!empty($products))
            for ($i = 0; $i < count($products); $i++) {
                $output .= ' <tr>
            <td>' . $products[$i]->getProductId() . '</td>
            <td>' . $products[$i]->getProductName() . '</td>
            <td>' . $products[$i]->getCategory() . '</td>
            <td>' . $products[$i]->getBrand() . '</td>
            <td>' . $products[$i]->getPrice() . ' $</td>
            <td class="nav justify-content-end">
                <a class="deleteProduct mx-2 text-danger" title="Delete Product" href="" url="/SafeRideStore/admin/products/delete/' . $products[$i]->getProductId() . '"><i class="fas fa-trash-alt"></i></a>
               <a class="mx-2 "title="View/Edit Product" href="products/edit/' . $products[$i]->getProductId() . '"><i class="far fa-eye"></i></a>
               <a class=" mx-2" title="Mange Product Stock" href="products/manage-stock/' . $products[$i]->getProductId() . '"><i class="fas fa-dolly"></i></a>
            </td>
            </tr>';
            }
        return $output;
    }
    /**
     * action for admin Customers page
     */
    public function adminCustomersAction()
    {
        $this->checkAdmin();
        //customers model
        $vars['customers'] = $this->model->getAllCustomers();
        $vars['admin'] = "";
        $this->view->render('Admin customers', $vars);
    }
    /**
     * action for admin Edit Products page
     */
    public function adminProductEditAction()
    {
        $this->checkAdmin();
        $id = intval($this->route['id']);
        if (isset($_POST['edit'])) {
            $product = $this->praperProduct();
            $vars['massage']  = $this->updateProduct($product, $id);
        }
        //products model
        $vars['products'] = $this->model->getById($id);
        $vars['admin'] = "";
        $vars['add/edit'] = "edit";
        $this->view->render('Admin Products Edit', $vars);
    }
    /**
     * action for admin add Products page
     */
    public function adminProductAddAction()
    {
        $this->checkAdmin();
        $vars['admin'] = "";
        $vars['add/edit'] = "add";
        if (isset($_POST['add'])) {
            $product = $this->praperProduct();
            $vars['massage']  = $this->addProduct($product);
        }
        $this->view->render('Admin Products add', $vars);
    }
    /**
     * action for admin delete Products page
     */
    public function adminProductDeleteAction()
    {
        $this->checkAdmin();
        //products model
        $vars['admin'] = "";
        $this->model->deleteProduct(intval($this->route['id']));
        $this->view->redirect("/SafeRideStore/admin/products");
    }
    /**
     * this function prapers product entity from post array 
     *
     * @return Product
     */
    public function praperProduct(): Product
    {
        $product = new Product();
        $product->setProductName($_POST['name']);
        $product->setProductId($_POST['id']);
        $product->setPrice($_POST['price']);
        $product->setCategory(trim($_POST['category']));
        $product->setSubCategory(trim($_POST['subCategory']));
        $product->setBrand($_POST['brand']);
        if ($product->getCategory() === 'helmet')
            $product->setImgPath("/SafeRideStore/public/images/products/" .  $product->getBrand() . "/" .   $product->getSubCategory() . "/" . $product->getProductId() . '.jpg');
        else
            $product->setImgPath("/SafeRideStore/public/images/products/RidingGear/" . $product->getSubCategory() . "/" . $product->getProductId() . '.jpg');
        return $product;
    }


    /**
     * action for admin Manage Stock page
     */
    public function adminManageStockAction()
    {
        $this->checkAdmin();
        $id = intval($this->route['id']);
        //products model
        $vars['products'] = $this->model->getInstockByProductId($id);
        $vars['id'] = $id;
        $vars['admin'] = "";
        $this->view->render('Admin Manage Stock', $vars);
    }

    /**
     * action for admin add product to stock page(Using Ajax)
     */
    public function addStockAction()
    {
        $this->checkAdmin();
        $id = intval($this->route['id']);
        $amount = intval($this->route['amount']);
        $color = $this->route['color'];
        $size = $this->route['size'];
        //products model
        if (!$this->model->isStockExists($id, $size, $color)) {
            echo  json_encode($this->model->addToStock($id, $size, $color, $amount));
        } else {
            echo  json_encode($this->model->updateStock($id, $size, $color, $amount));
        }
    }
    /**
     * action for update Stock page
     */
    public function updateStockAction()
    {
        $this->checkAdmin();
        $inStockid = intval($this->route['id']);
        $quantity = intval($this->route['amount']);
        if ($quantity == 0)
            $this->model->deleteStockById($inStockid);
        else
            $this->model->updateStockById($inStockid, $quantity);
    }
    /**
     * action for sorting orders by dates
     */
    public function adminOrdersDatesAction()
    {
        $this->checkAdmin();
        $sDate = $_POST['startDate'];
        $eDate = $_POST['endDate'] . '23:59:59';
        //geting orders between entered dates
        $orders = $this->model->getOrdersByDate($sDate, $eDate);
        echo $this->praperOrders($orders);
    }
    /**
     * action for sorting orders by dates
     */
    public function adminOrdersUserAction()
    {
        $this->checkAdmin();
        $userName = $_POST['userName'];
        //geting orders made by customers with entered user name
        $orders = $this->model->getOrdersByUserName($userName);
        echo $this->praperOrders($orders);
    }
    /**
     * this function prepare tabele for geten orders
     *
     * @param  array $orders array of orders
     * @return string (string for html) tabele of orders
     */
    public function praperOrders($orders)
    {
        $output = "";
        for ($i = 0; $i < count($orders); $i++) {
            $status = $orders[$i]->getOrderStatus();
            $output .= '<tr>
            <td>' . $orders[$i]->getOrderId() . '</td>
            <td>' . $orders[$i]->getUserName() . '</td>
            <td>' . $orders[$i]->getTotalAmount() . ' $</td>
            <td> <select name="orderStatus" id="status" data-id=' . $orders[$i]->getOrderId() . '>
            <option value="new order">new order</option>
            <option value="in process">in process</option>
            <option value="completed">completed</option>
            </select></td>
            <td>' . $orders[$i]->getOrderDate() . ' </td>
            <td class="nav justify-content-end">
            <a class="mx-2" title="View/Edit Order" href="order/viewOrder/' . $orders[$i]->getOrderId() . '"><i class="far fa-eye"></i></a>
            </td>
        </tr> ';
        }
        return $output;
    }

    /**
     * action for admin orders page
     */
    public function adminOrdersAction()
    {
        $this->checkAdmin();
        $vars['admin'] = "";
        $orders = $this->model->getOrders();
        $vars['orders'] = $this->praperOrders($orders);
        $this->view->render('Admin Orders', $vars);
    }
    /**
     * action for admin view order diteils page
     */
    public function adminViewOrderAction()
    {
        $this->checkAdmin();
        $id = intval($this->route['id']);
        $vars['admin'] = "";
        $productsInOrder = $this->model->productsInOrder($id); # array of inStock Ids
        $vars['order'] = $this->model->getOrderById($id);
        $vars['customer'] = $this->model->getCustomerByOrder($id);
        $vars['products'] = $this->model->getOrderProdustsByIds($productsInOrder);
        $this->view->render('Admin View Order ', $vars);
    }
    /**
     * action for changing vat
     */
    public function changeVatAction()
    {
        $this->checkAdmin();
        Cart::setVat(intval($_POST['inputvat']));
        $this->view->redirect("/SafeRideStore/admin");
    }

    /**
     * this fanction updates proudct data
     *
     * @param  Product $product product to update
     * @param   $oldId current product id
     * @return string relevant massage
     */
    private function updateProduct($product, $oldId)
    {
        $newId = $_POST['id'];
        $flag = 0;
        //Checking if there is same Id in Data Base in case the id needs to be changed.
        if ($oldId != $newId) {
            $flag = $this->model->checkId($newId);
        }
        if (!$flag) {
            if ($this->model->updateProduct($product, $oldId)) {
                // if file uploaded move and rename
                if (is_uploaded_file($_FILES["image"]["tmp_name"]))
                    move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "{$product->getImgPath()}");
                $message = "<div class='text-success mb-4 font-weight-bold '>Product data updated successfully </div>";
            } //Can`t changing Id,because of Same ID in our DB.
        } else
            $message = "<div class='text-danger font-weight-bold mb-2'>Product with same id already exists</div>";
        return $message;
    }
    private function addProduct($product)
    {
        //Checking if there is same Id in Data Base in case the id needs to be changed.
        $flag = $this->model->checkId($product->getProductId());
        if (!$flag) {
            $this->model->addProduct($product);
            // if file uploaded move and rename
            if (is_uploaded_file($_FILES["image"]["tmp_name"]))
                move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "{$product->getImgPath()}");
            $message = "<div class='text-success mb-4 font-weight-bold '>Product added succesfully</div>";
        } //Can`t changing Id,because of Same ID in our DB.
        else
            $message = "<div class='text-danger font-weight-bold mb-2'>Product with same id already exists</div>";
        return   $message;
    }


    /**
     * function checkout admin role promission if no prommision redirect to page erorr 403
     */
    private function checkAdmin()
    {
        if (!isset($_SESSION['admin']))
            View::errorCode(403);
    }
}
