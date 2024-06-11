<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Corytech\Tracing\EventListener\TracingEventSubscriber;
use Corytech\Tracing\GlobalExceptionCatcher;
use Corytech\Tracing\Messenger\Middleware\RequestIdMiddleware;
use Corytech\Tracing\Monolog\Processor\XRequestIdMonologProcessor;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->defaults()
            ->autoconfigure()
            ->autowire()
        ->set(TracingEventSubscriber::class, TracingEventSubscriber::class)
        ->set(RequestIdMiddleware::class, RequestIdMiddleware::class)
        ->set(XRequestIdMonologProcessor::class, XRequestIdMonologProcessor::class)
        ->set(GlobalExceptionCatcher::class, GlobalExceptionCatcher::class)
    ;
};
