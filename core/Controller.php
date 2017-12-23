<?php

namespace Av\Core;

/**
 * Class Controller
 * @package Av\Controllers
 */
class Controller
{
    /**
     * Handles home pages
     *
     * @param Request $request
     * @return string
     */
    public function page404(Request $request)
    {
        return View('page404');
    }

    /**
     * Handles home pages
     *
     * @param Request $request
     * @return string
     */
    public function page403(Request $request)
    {
        return '403';
    }
}