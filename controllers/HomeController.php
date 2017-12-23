<?php

namespace Av\Controllers;

use Av\Core\Controller;
use Av\Core\Requests\Request;
use Av\Models\Product;

/**
 * Class Controller
 * @package Av\Controllers
 */
class HomeController extends Controller
{
    /**
     * Handles home pages
     *
     * @param Request $request
     * @return string
     */
    public function home(Request $request)
    {
        $product = Product::create(['name' => 'test2']);
        return View('home');
    }
}