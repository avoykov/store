<?php

namespace Av\Core;

use Av\Core\Requests\Request;

/**
 * Class Controller
 * @package Av\Controllers
 */
class Controller
{
    /**
     * Handler for page 404.
     *
     * @param Request $request
     * @return string
     */
    public function page404(Request $request)
    {
        return response()->view('page404');
    }

    /**
     * Handler for errorPage.
     *
     * @param Request $request
     * @return string
     */
    public function pageError(Request $request)
    {
        return response()->view('pageError');
    }

    /**
     * Handler for page 403
     *
     * @param Request $request
     * @return string
     */
    public function page403(Request $request)
    {
        return response()->view('page404');
    }
}