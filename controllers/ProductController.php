<?php

namespace Av\Controllers;

use Av\Core\Requests\Request;
use Av\Models\Product;

/**
 * Class OrderController
 * @package Av\controllers
 */
class ProductController
{
    /**
     * Handler for viewing product.
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function view(Request $request, $id)
    {
        $product = Product::load($id);

        return response()->view('product', ['product' => $product]);
    }

    /**
     * Adds product to cart.
     *
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function add(Request $request, $id)
    {
        if (Product::exists($id)) {
            $request->session->addProduct($id);
        }
        return response()->redirect('/cart');
    }

    /**
     * Removes product from cart.
     *
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function remove(Request $request, $id)
    {
        if (Product::exists($id)) {
            $request->session->removeProduct($id, true);
        }
        return response()->back(['messages' => ['Successfully removed from cart']]);
    }

    /**
     * Change quantity of product.
     *
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function quantity(Request $request, $id)
    {
        $rules = [
            'quantity' => [
                'filter' => FILTER_VALIDATE_INT,
                'message' => 'Quantity should be numeric.'
            ]
        ];
        $errors = [];
        if (!$request->validate($rules, $errors)) {
            return response()->back(['errors' => $errors]);
        }

        if (Product::exists($id)) {
            $quantity = $request->get('quantity');
            if ($request->get('add')) {
                $request->session->setQuantity($id, $quantity + 1);
            } else {
                if ($quantity == 1) {
                    $request->session->removeProduct($id, true);
                } else {
                    $request->session->setQuantity($id, $quantity - 1);
                }
            }

        }
        return response()->back(['messages' => ['Successfully changed quantity']]);
    }

}