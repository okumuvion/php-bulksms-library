<?php

declare(strict_types=1);

namespace Eddieodira\Messager\Entities;

use CodeIgniter\Entity\Entity;

class SMSTemplate extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];
}
