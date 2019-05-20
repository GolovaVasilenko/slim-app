<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
$auth = function($request, $response, $next) {
    $auth = $this->get('auth');

    if($auth->isRemembered() || $auth->isLoggedIn()) {

        $response = $next($request, $response);

        return $response;
    }

    return $response->withRedirect('/login');

};

$is_auth = function($request, $response, $next) {
    $auth = $this->get('auth');

    if ($request->getRequestTarget() == '/login' || $request->getRequestTarget() == '/registration') {
        if($auth->isRemembered() || $auth->isLoggedIn()) {
            return $response->withRedirect('/');
        }
    }
    $response = $next($request, $response);

    return $response;
};

$admin = function($request, $response, $next) {
    $auth = $this->get('auth');

    if($auth->isRemembered() || $auth->isLoggedIn()) {
        if ($auth->hasRole(\Delight\Auth\Role::ADMIN)) {
            $response = $next($request, $response);

            return $response;
        }
    }
    return $response->withRedirect('/login');
};