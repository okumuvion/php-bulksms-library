<?php

declare(strict_types=1);

namespace Eddieodira\Messager\Migrations;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Migration;

class CreateSmsRecordsTable extends Migration
{
    protected $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = setting('Bulksms.recordsTable') ?? 'sms_records';
    }

    public function up()
    {
        $this->forge->addField([
            'id'         => [
                'type' => 'int', 
                'constraint' => 11, 
                'unsigned' => true, 
                'auto_increment' => true
            ],
            'template_id'  => [
                'type' => 'int', 
                'constraint' => 11, 
                'unsigned' => true, 
                'null' => false
            ],
            'recipient'       => [
                'type' => 'varchar', 
                'constraint' => 50, 
                'null' => false
            ],
            'message'    => [
                'type' => 'text',
                'null' => false
            ],
            'status'       => [
                'type' => 'varchar', 
                'constraint' => 50, 
                'default'    => 'pending',
            ],
            'response'    => [
                'type' => 'text',
                'null' => false
            ],
            'created_at' => [
                'type' => 'datetime', 
                'default' => new RawSql('CURRENT_TIMESTAMP')
            ],
            'updated_at' => [
                'type' => 'datetime', 
                'null' => true
            ],
        ]);

        $this->forge->addKey('id', true);
        // Foreign key with NO ACTION on delete/update
        $this->forge->addForeignKey(
            'template_id',
            'sms_templates',
            'id',
            'NO ACTION',
            'NO ACTION'
        );
        // Add table options here
        $this->forge->createTable($this->table, true, [
            'ENGINE'          => 'InnoDB',
            'CHARSET'         => 'utf8mb4',
            'COLLATE'         => 'utf8mb4_general_ci',
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable($this->table, true);
    }
}
