<?php

/**
 *  application apps
 */

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', env('CORS_ALLOW_ORIGIN', '*'))
        ->withHeader('Access-Control-Allow-Headers', env('CORS_ALLOW_HEADERS', '*'))
        ->withHeader('Access-Control-Allow-Methods', env('CORS_ALLOW_METHODS', 'GET, POST, PUT, DELETE, PATCH, OPTIONS'))
        ->withHeader('Access-Control-Allow-Credentials', env('CORS_ALLOW_CREDENTIALS', 'true'));
});

$app->get('/', function ($request, $response) {
    $response->getBody()->write(json_encode([
        'status' => 'ok',
        'message' => 'Welcome to the Mlab Mailer API - contact sales at sales@mlabfactory.com for more information.',
    ]));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->group('/email', function ($group) {
    $group->post('/notify/contact', ['\Mlab\Mailer\Http\Controller\SendMailController', 'sendEmail']);
})->add(new \Mlab\Mailer\Http\Middleware\SecurityMiddleware())
    ->add(new \Mlab\Mailer\Http\Middleware\RateLimitMiddleware());
