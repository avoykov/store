<?php

namespace Av\controllers;

use Av\Core\Requests\Request;
use Av\Core\Responses\Response;
use Av\Models\Bonus;
use Av\Models\Product;

/**
 * Class OrderController
 * @package Av\controllers
 */
class CartController
{
    /**
     * Handles cart page.
     *
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function cart(Request $request)
    {
        $bonus = null;
        $products = [];
        $price = $discount = $amount = 0;
        $bid = $request->session->get('bonus', 0);

        $productsData = $request->session->getProducts();
        $ids = array_keys($productsData);

        if (!empty($ids)) {
            $products = Product::load($ids);
            foreach ($products as $product) {
                $product->quantity = $productsData[$product->getId()];
                $amount += $product->quantity;
                $price += $product->price * $product->quantity;
            }

            if ($amount >= 3) {
                $discount += 10;
            }

            if (!empty($bid)) {
                try {
                    $bonus = Bonus::load($bid);
                } catch (\Exception $ex) {
                    $request->session->remove('bonus');
                }
                $discount += $bonus->discount;
            }

            if ($discount) {
                $price = $price - $price * ($discount / 100);
            }
        }

        return response()->view('cart', [
            'products' => $products,
            'price' => number_format($price, 2, '.', ''),
            'bonus' => $bonus ? $bonus->discount : null,
            'amount' => $amount,
            'discount' => $discount
        ]);
    }

    /**
     * Handler for actions on cart page.
     *
     * @param Request $request
     * @return Response
     */
    public function cartCheckout(Request $request)
    {
        return response()->redirect('/checkout');
    }

    /**
     * Handler for actions on cart page.
     *
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function cartBonus(Request $request)
    {
        $rules = [
            'coupon_code' => [
                'filter' => FILTER_VALIDATE_INT,
                'message' => 'Please enter valid coupon.'
            ]
        ];
        $errors = [];
        if (!$request->validate($rules, $errors)) {
            return response()->back(['errors' => $errors]);
        }

        $id = $request->get('coupon_code');
        if (!Bonus::exists($id)) {
            return response()->back(['errors' => ['Enter existing coupon']]);
        }

        $request->session->set('bonus', $id);

        return response()->redirect('/cart');
    }

}