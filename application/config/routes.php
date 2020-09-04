<?php
return [
    '' => [
        'controller' => 'main',
        'action' => 'index',
        'view' => 'index'
    ],
    'account/login' => [
        'controller' => 'account',
        'action' => 'login',
        'view' => 'login'
    ],
    'account/register' => [
        'controller' => 'account',
        'action' => 'register',
        'view' => 'register'
    ],
    'account/logout' => [
        'controller' => 'account',
        'action' => 'logout',
    ],
    'cart' => [
        'controller' => 'cart',
        'action' => 'cart',
        'view' => 'cart'
    ],
    'cart/addAjax/[A-Za-z]+/[A-Za-z]+/[0-9]+/[0-9]+' => [
        'controller' => 'cart',
        'action' => 'addAjax',
        'view' => 'cart',
        'id' => '',
        'amount' => '',
        'size' => '',
        'color' => ''

    ],
    'cart/incAjax/[0-9]+' => [
        'controller' => 'cart',
        'action' => 'incAjax',
        'view' => 'cart',
        'id' => '',

    ], 'cart/decAjax/[0-9]+' => [
        'controller' => 'cart',
        'action' => 'decAjax',
        'view' => 'cart',
        'id' => '',

    ],
    'cart/delete/[0-9]+' => [
        'controller' => 'cart',
        'action' => 'delete',
        'view' => 'cart',
        'id' => ''
    ],
    'order/checkout
      ' => [
        'controller' => 'order',
        'action' => 'checkOut',
        'view' => 'payPal',
    ],
    'productDetails/[0-9]+' => [
        'controller' => 'products',
        'action' => 'productDetails',
        'view' => 'productDetails',
        'id' => ''
    ],
    'products/helmets' => [
        'controller' => 'products',
        'action' => 'productByCategory',
        'view' => 'products',
        'category' => 'helmets'
    ],
    'products/full-face-helmets' => [
        'controller' => 'products',
        'action' => 'productBySubCategory',
        'view' => 'products',
        'category' => 'fullFace'
    ],
    'products/modular' => [
        'controller' => 'products',
        'action' => 'productBySubCategory',
        'view' => 'products',
        'category' => 'modular'
    ],
    'products/dualSport' => [
        'controller' => 'products',
        'action' => 'productBySubCategory',
        'view' => 'products',
        'category' => 'dualSport'
    ],
    'products/dirt-helmet' => [
        'controller' => 'products',
        'action' => 'productBySubCategory',
        'view' => 'products',
        'category' => 'dirtHelmet'
    ],
    'products/half-helmet' => [
        'controller' => 'products',
        'action' => 'productBySubCategory',
        'view' => 'products',
        'category' => 'halfHelmet'
    ],
    'products/open-face-helmet' => [
        'controller' => 'products',
        'action' => 'productBySubCategory',
        'view' => 'products',
        'category' => 'openFace'
    ],
    'products/accessories' => [
        'controller' => 'products',
        'action' => 'productBySubCategory',
        'view' => 'products',
        'category' => 'accessories'
    ],
    'admin' => [
        'controller' => 'admin',
        'action' => 'admin',
        'view' => 'admin',
    ],
    'admin/products' => [
        'controller' => 'admin',
        'action' => 'adminProducts',
        'view' => 'adminProducts',
        'model' => 'products'
    ],
    'admin/products/edit/[0-9]+' => [
        'controller' => 'admin',
        'action' => 'adminProductEdit',
        'view' => 'adminProductEdit',
        'model' => 'products',
        'id' => ''
    ],
    'admin/customers' => [
        'controller' => 'admin',
        'action' => 'adminCustomers',
        'view' => 'adminCustomers',
        'model' => 'account'
    ]

];
