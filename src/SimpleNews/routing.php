<?php

declare(strict_types=1);
namespace App\SimpleNews;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->import('./Controller/', 'annotation');
};
