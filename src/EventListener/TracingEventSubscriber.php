<?php

declare(strict_types=1);

namespace Corytech\Tracing\EventListener;

use Corytech\Tracing\XRequestIdExtractor;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class TracingEventSubscriber implements EventSubscriberInterface
{
    public function handleControllerEvent(ControllerEvent $event): void
    {
        \Sentry\configureScope(function (\Sentry\State\Scope $scope): void {
            $scope->setContext('request', [
                'x-request-id' => XRequestIdExtractor::getRequestId(),
            ]);
        });
    }

    public function handleResponseEvent(ResponseEvent $event): void
    {
        $event->getResponse()->headers->set('x-request-id', XRequestIdExtractor::getRequestId());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ControllerEvent::class => 'handleControllerEvent',
            ResponseEvent::class => 'handleResponseEvent',
        ];
    }
}
