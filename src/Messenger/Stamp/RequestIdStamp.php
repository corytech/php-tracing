<?php

declare(strict_types=1);

namespace Corytech\Tracing\Messenger\Stamp;

use Symfony\Component\Messenger\Stamp\StampInterface;

class RequestIdStamp implements StampInterface
{
    private ?string $requestId;

    public function __construct(?string $requestId)
    {
        $this->requestId = $requestId;
    }

    public function getRequestId(): ?string
    {
        return $this->requestId;
    }
}
