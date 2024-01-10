<?php

use App\Controller\User\CreateUserController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
   $routes
        ->add('app_create_user', '/')
        ->controller(CreateUserController::class)
        ->methods(['POST']);

   $routes
        ->add('app_show_user', '/{userId}')
        ->controller(CreateUserController::class)
        ->methods(['GET'])
        ->requirements([
            'userId' => '\d+'
        ]);
};