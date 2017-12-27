<?php

namespace Av\Controllers;


use Av\Core\Requests\Request;
use Av\Core\Responses\Response;
use Av\Models\Order;

/**
 * Class OrderController
 * @package Av\controllers
 */
class OrderController
{
    /**
     * Shows order page to user.
     *
     * @param Request $request
     * @param $hash
     * @return Response
     */
    public function index(Request $request, $hash)
    {
        try {
            $order = Order::load($hash, 'id');
        } catch (\Exception $ex) {
            return response()->back(['errors' => ['Cant load such request']]);
        }

        return response()->view('order', ['order' => $order]);
    }

}