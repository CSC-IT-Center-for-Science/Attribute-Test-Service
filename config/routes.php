<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin(
    'Cscfi/AttributeTestService',
    ['path' => '/attribute'],
    function (RouteBuilder $routes) {
        $routes->fallbacks('DashedRoute');
    }
);
