<?php

declare(strict_types=1);

namespace App\SimpleNews;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function(ContainerConfigurator $di): void {
    $services = $di->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->load(__NAMESPACE__.'\\', '.')
        ->exclude('./{Entity,Command.php,di.php,routing.php}');

    $di->extension(
        'doctrine',
        [
            'orm' => [
                'mappings' => [
                    __NAMESPACE__ => [
                        'is_bundle' => false,
                        'type'      => 'attribute',
                        'dir'       => __DIR__.'/Entity',
                        'prefix'    => __NAMESPACE__.'\Entity',
                        'alias'     => basename(__DIR__),
                    ],
                ],
            ],
        ]
    );

    $di->extension(
        'framework',
        [
            'messenger' => [
                'routing' => [
                    UseCase\Create\Command::class => 'async',
                ],
            ],
        ]
    );
};
