<?php

declare(strict_types=1);

namespace Eddieodira\Messager\Models;

use Eddieodira\Messager\Entities\SMSRecord;

class SMSRecordsModel extends BaseModel
{
    protected $table            = 'sms_records';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = SMSRecord::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "template_id",
        "recipient",
        "message",
        "status",
        "response"
    ];

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
        
        $this->table = setting('Bulksms.recordsTable') ?? 'sms_records';
    }

    /**
     * Returns a new Entity.
     *
     * @param array<string, array<array-key, mixed>|bool|float|int|object|string|null> $data (Optional) data
     */
    public function newSMSRecord(array $data = []): SMSRecord
    {
        return new $this->returnType($data);
    }
}
