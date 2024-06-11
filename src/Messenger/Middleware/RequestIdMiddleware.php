<?php

declare(strict_types=1);

namespace Corytech\Tracing\Messenger\Middleware;

use Corytech\Tracing\Messenger\Stamp\RequestIdStamp;
use Corytech\Tracing\XRequestIdExtractor;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class RequestIdMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        /** @var RequestIdStamp $stamp */
        $stamp = $envelope->last(RequestIdStamp::class);
        if ($stamp === null) {
            $envelope = $envelope->with(new RequestIdStamp(XRequestIdExtractor::getRequestId()));
        } else {
            XRequestIdExtractor::setRequestId($stamp->getRequestId());
            \Sentry\configureScope(function (\Sentry\State\Scope $scope): void {
                $scope->setContext('request', [
                    'x-request-id' => XRequestIdExtractor::getRequestId(),
                ]);
            });
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
