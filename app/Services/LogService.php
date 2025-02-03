<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class LogService
{
    public static function info(string $message, array $context = [])
    {
        Log::info($message, $context);
    }

    public static function error(string $message, array $context = [])
    {
        Log::error($message, $context);
    }
}
