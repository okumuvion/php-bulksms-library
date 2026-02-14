<?php

declare(strict_types=1);

namespace Eddieodira\Messager\Models;

use Eddieodira\Messager\Entities\SMSTemplate;

class SMSTemplatesModel extends BaseModel
{
    protected $table            = 'sms_templates';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = SMSTemplate::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["code", "name", "content"];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get config table name.
     *
     * @return string
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->table = setting('Bulksms.smsTemplateTable') ?? 'sms_templates';
    }

    /**
     * Returns a new Entity.
     *
     * @param array<string, array<array-key, mixed>|bool|float|int|object|string|null> $data (Optional) data
     */
    public function newSMSTemplate(array $data = []): SMSTemplate
    {
        return new $this->returnType($data);
    }
}
