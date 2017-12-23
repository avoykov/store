<?php

namespace Av\Controllers;

use Av\Core\Controller;
use Av\Core\Request;

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
        return view('home');
    }
}