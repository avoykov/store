<?php

namespace Av\controllers;

use Av\Core\Database\DB;
use Av\Core\Requests\Request;
use Av\Models\Bonus;
use Av\Models\Order;

class CheckoutController
{

    /**
     * Handles checkout page.
     *
     * @param Request $request
     * @return string
     */
    public function checkout(Request $request)
    {
        return response()->view('checkout');
    }

    /**
     * Handles checkout page.
     *
     * @param Request $request
     * @return string
     */
    public function checkoutSave(Request $request)
    {
        $products = $request->session->getProducts();
        $bid = (int)($request->session->get('bonus', null));

        $rules = [
            'email' => [
                'filter' => FILTER_VALIDATE_EMAIL,
                'message' => 'Please enter valid email.'
            ],
            'card_number' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['options' => ['regexp' => '/\d{16}/']],
                'message' => 'Please enter valid card number.'
            ],
            'cvv' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['options' => ['regexp' => '/\d{4}/']],
                'message' => 'Please enter valid CVV.'
            ],
        ];

        $errors = [];
        if (empty($products)) {
            $errors[] = 'Empty cart, go back and order something.';
        }

        if (empty($request->get('name'))) {
            $errors[] = 'Please enter valid name';
        }

        if (empty($request->get('phone'))) {
            $errors[] = 'Please enter valid phone';
        }

        if (!$request->validate($rules, $errors)) {
            return response()->back(['errors' => $errors]);
        }

        try {
            DB::beginTransaction();

            Order::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'card_number' => (int)$request->get('card_number'),
                'cvv' => (int)$request->get('cvv'),
                'created' => time(),
                'bid' => $bid,
                'closed' => time(),
                'status' => 0,
                'products' => $products,
            ]);

            if (!empty($bid)) {
                Bonus::load($bid)->delete();
            }

            $request->session->clearOrder();

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->back(['errors' => $errors]);
        }

        return response()->redirect('/');
    }

}