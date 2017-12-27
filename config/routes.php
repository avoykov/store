<?php
/**
 * @file
 * Contains base mapping between routes and handlers.
 */

return [
    '/home' => [
        'handler' => '\Av\Controllers\HomeController::home',
        'method' => 'get',
    ],
    '/cart' => [
        'handler' => '\Av\Controllers\CartController::cart',
        'method' => 'get',
    ],
    '/cart/checkout' => [
        'handler' => '\Av\Controllers\CartController::cartCheckout',
        'method' => 'post',
    ],
    '/cart/bonus' => [
        'handler' => '\Av\Controllers\CartController::cartBonus',
        'method' => 'post',
    ],
    '/product/{id:\d+}' => [
        'handler' => '\Av\Controllers\ProductController::view',
        'method' => 'get',
    ],
    '/product/{id:\d+}/add' => [
        'handler' => '\Av\Controllers\ProductController::add',
        'method' => 'post',
    ],
    '/product/{id:\d+}/remove' => [
        'handler' => '\Av\Controllers\ProductController::remove',
        'method' => 'post',
    ],
    '/product/{id:\d+}/quantity' => [
        'handler' => '\Av\Controllers\ProductController::quantity',
        'method' => 'post',
    ],
    '/checkout' => [
        'handler' => '\Av\Controllers\CheckoutController::checkout',
        'method' => 'get',
    ],
    '/checkout/save' => [
        'handler' => '\Av\Controllers\CheckoutController::checkoutSave',
        'method' => 'post',
    ],
    '/order/{hash:[\d\w]+}' => [
        'handler' => '\Av\Controllers\OrderController::index',
        'method' => 'get',
    ]
];