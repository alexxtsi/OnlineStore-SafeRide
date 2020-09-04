<?php

use application\components\Customer;

$customers = $vars['customers'];
?>
<div class="container">
    <h2>Customers</h2>
    <p>The .thead-dark class adds a black background to table headers, and the .thead-light class adds a grey background to table headers:</p>
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