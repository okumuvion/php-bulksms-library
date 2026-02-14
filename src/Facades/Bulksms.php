<?php

declare(strict_types=1);

namespace Eddieodira\Messager\Facades;

use Eddieodira\Messager\Bulksms as BulksmsClient;

/**
 * @see \Fluent\Eddieodira\Messager\Bulksms
 */
class Bulksms
{
    /**
     * @param $method
     * @param $arguments
     * @return BulksmsClient
     */
    public static function __callStatic($method, $arguments)
    {
        return (new BulksmsClient())->$method(...$arguments);
    }
}