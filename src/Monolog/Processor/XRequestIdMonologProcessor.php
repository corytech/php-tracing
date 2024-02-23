<?php

declare(strict_types=1);

namespace Corytech\Tracing\Monolog\Processor;

use Corytech\Tracing\XRequestIdExtractor;
use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('monolog.processor')]
class XRequestIdMonologProcessor implements ProcessorInterface
{
    public function __invoke(LogRecord $record): LogRecord
    {
        $record->extra['x_request_id'] = XRequestIdExtractor::getRequestId();

        return $record;
    }
}
