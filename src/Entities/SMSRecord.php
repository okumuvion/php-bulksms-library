<?php

declare(strict_types=1);

namespace Eddieodira\Messager\Entities;

use CodeIgniter\Entity\Entity;

class SMSRecord extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
