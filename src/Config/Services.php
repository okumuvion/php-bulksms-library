<?php

declare(strict_types=1);

namespace Eddieodira\Messager\Config;

use Eddieodira\Messager\Bulksms;
use CodeIgniter\Config\BaseService;

class Services extends BaseService
{
    public static function bulksms(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('bulksms');
        }

        return new Bulksms();
    }
}
