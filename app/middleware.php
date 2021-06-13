<?php

use App\Application\Middleware\SessionMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(SessionMiddleware::class);

    $twig = \Slim\Views\Twig::create('../templates', ['cache' => false]);
    $app->add(\Slim\Views\TwigMiddleware::create($app, $twig));
};
