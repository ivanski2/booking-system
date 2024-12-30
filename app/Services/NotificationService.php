<?php

namespace App\Services;

class NotificationService
{
    /**
     * @param string $type (SMS, Email, ...)
     * @param string $clientName
     * @return string
     */
    public function notify(string $type, string $clientName): string
    {
        return "{$type} notification is send to {$clientName}.";
    }
}
