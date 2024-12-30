<?php
namespace App\Test;
use Psr\Log\AbstractLogger;

class TestLogger extends AbstractLogger
{
    private array $logs = [];

    public function log($level, $message, array $context = []): void
    {
        $this->logs[] = compact('level', 'message', 'context');
    }
}
?>