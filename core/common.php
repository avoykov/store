<?php

use Av\Core\Kernel;
use Av\Core\Responses\Response;

/**
 * Helper for creating response.
 *
 * @return mixed
 */
function response()
{
    return new Response();
}

/**
 * Helper for getting session.
 *
 * @return \Av\Core\Session\Session
 */
function session()
{
    return Kernel::getRequest()->session;
}

/**
 * Helper for csrf token generation.
 *
 * @return string
 */
function csrf_token()
{
    if (session()->has('csrf_token') && ((time() - session()->get('csrf_token_created')) < 3600)) {
        return session()->get('csrf_token');
    } else {
        $token = hash_hmac('sha256', uniqid(rand() . session()->getId(), true), Kernel::$key);
        session()->set('csrf_token', $token);
        session()->set('csrf_token_created', time());
        return $token;
    }

}

/**
 *  Helper for generating full url.
 *
 * @param string $path
 * @return string
 */
function full_url($path = '/')
{
    $request = Kernel::getRequest();
    $domain = "{$request->scheme}://{$request->domain}";
    if ($path[0] != '/') {
        $domain .= '/';
    }
    return $domain . $path;
}