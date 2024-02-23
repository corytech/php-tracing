<?php

declare(strict_types=1);

namespace Corytech\Tracing;

class XRequestIdExtractor
{
    private static ?string $requestId = null;

    public static function getRequestId(): string
    {
        if (self::$requestId === null) {
            self::$requestId = $_SERVER['X_REQUEST_ID'] ?? $_SERVER['HTTP_X_REQUEST_ID'] ?? md5(microtime());
        }

        return self::$requestId;
    }

    public static function setRequestId(?string $requestId): void
    {
        self::$requestId = $requestId;
    }

    public static function refreshRequestId(): void
    {
        self::setRequestId(md5(microtime()));
    }
}
