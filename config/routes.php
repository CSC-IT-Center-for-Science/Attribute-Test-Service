<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin(
    'Attribute',
    ['path' => '/attribute'],
    function (RouteBuilder $routes) {
        $routes->fallbacks('DashedRoute');
    }
);
});
