<?php

declare(strict_types=1);

namespace Corytech\Tracing;

use Psr\Log\LoggerInterface;

readonly class GlobalExceptionCatcher
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    public function captureException(\Throwable $e, array $additionalContexts = []): void
    {
        $this->logger
            ->warning(
                sprintf('[GlobalExceptionCatcher] %s: %s', $e::class, $e->getMessage()),
                array_merge($additionalContexts, [
                    'exception' => $e,
                    'trace' => $e->getTraceAsString(),
                ])
            );

        \Sentry\withScope(function (\Sentry\State\Scope $scope) use ($e, $additionalContexts) {
            foreach ($additionalContexts as $contextName => $contextData) {
                $scope->setContext($contextName, $contextData);
            }
            \Sentry\captureException($e);
        });
    }
}
