<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    $routes->import('@ViewpointAdminBundle/Resources/config/routes.yaml');
    $routes->import('@ViewpointThemeBundle/Resources/config/routes.yaml');

    // api routes
    $routes->import('./routes/api/api.php')
        ->prefix('/api');
    
    $routes->add('api_login_check', '/api/login_check')
        ->methods(['POST']); 
};