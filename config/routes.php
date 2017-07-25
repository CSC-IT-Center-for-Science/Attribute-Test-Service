<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin(
    'cscfi/AttributeTestService',
    ['path' => '/attribute'],
    function (RouteBuilder $routes) {
        $routes->fallbacks('DashedRoute');
    }
);
