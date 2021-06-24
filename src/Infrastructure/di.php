<?php

declare(strict_types=1);

namespace App\Infrastructure;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Messenger\Middleware\ValidationMiddleware;

return static function(ContainerConfigurator $di): void {
    $di->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->load(__NAMESPACE__.'\\', '.')
        ->exclude('./{Entity,Psalm,Command.php,di.php,routing.php}');

    $di->extension(
        'framework',
        [
            'messenger' => [
                'buses' => [
                    'messenger.bus.default' => [
                        'middleware' => [
                            'messenger.middleware.validation',
                            'messenger.middleware.doctrine_transaction',
                        ],
                    ],
                ],
            ],
        ]
    );
};
