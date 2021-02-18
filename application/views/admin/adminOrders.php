<?php

use application\components\Order;

$orders = $vars['orders'];
?>
<div class="container">
    <div class="row justify-content-center title">
        <h2>Orders</h2>
    </div>
    <form action="" class="form-inline" method="POST">
        <div>
            <label class="justify-content-start"> Search Orders Between dates:</label>
            <input type="date" class="form-control" id="startDate" min="2019-01-01" max="2050-01-01" required>
            <input type="date" class="form-control" id="endDate" min="2019-01-01" max="2050-01-01" required>
            <button class="btn btn-primary" id="searchByDate" value="searchByDate">Search</button>
        </div>
    </form>
    <form action="" class="form-inline" method="POST">
        <div>
            <label class="justify-content-start"> Search Orders By User Name:</label>
            <input type="text" class="form-control" id="userName" required>
            <button class="btn btn-primary" id="searchByUserName" value="searchByUserName">Search</button>
        </div>
    </form>
    <div class="row">
        <div class="col-8">
            <div class="pt-2">

            </div>
        </div>
    </div>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Order ID</th>
                <th>User Name</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Order Date</th>
                <th></th>

            </tr>
        </thead>
        <tbody class="orderBody">
            <?php
            if (!empty($orders))
                echo $orders;

            ?>

        </tbody>
    </table>