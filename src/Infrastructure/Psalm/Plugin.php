<?php

declare(strict_types=1);

namespace App\Infrastructure\Psalm;

use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;
use SimpleXMLElement;

class Plugin implements PluginEntryPointInterface
{
    public function __invoke(RegistrationInterface $registration, ?SimpleXMLElement $config = null): void
    {
        require_once __DIR__.'/RequiredPropertyHandler.php';
        $registration->registerHooksFromClass(RequiredPropertyHandler::class);
        require_once __DIR__.'/ContainerAwareTraitHandler.php';
        $registration->registerHooksFromClass(ContainerAwareTraitHandler::class);
    }
}
