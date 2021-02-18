<?php

use application\components\Customer;

$customers = $vars['customers'];
?>
<div class="container ">

    <div class="row justify-content-center title">
        <h2>Customers</h2>
    </div>
    <div class="row justify-content-center s-title">
        <p>Those are registered Customers</p>
    </div>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>User name</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Phone number</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($customers))
                for ($i = 0; $i < count($customers); $i++) {
            ?>
                <tr>
                    <td><?= $customers[$i]->getUserName() ?></td>
                    <td><?= $customers[$i]->getfirstName() ?></td>
                    <td><?= $customers[$i]->getlastName() ?></td>
                    <td><?= $customers[$i]->getEmail() ?></td>
                    <td><?= $customers[$i]->getPhoneNumber() ?></td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>