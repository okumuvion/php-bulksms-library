<?php

declare(strict_types=1);

namespace Eddieodira\Messager\Migrations;

use CodeIgniter\Database\Migration;

class CreateSmsTemplatesTable extends Migration
{
    protected $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = setting('Bulksms.smsTemplateTable') ?? 'sms_templates';
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
            'code'       => [
                'type' => 'varchar', 
                'constraint' => 255, 
                'null' => false,
                'unique' => true
            ],
            'name'       => [
                'type' => 'varchar', 
                'constraint' => 255, 
                'null' => false
            ],
            'content'    => [
                'type' => 'text',
                'null' => false
            ],
            'placeholders' => [
                'type' => 'text',
                'null' => true
            ],
            'created_at' => [
                'type' => 'datetime', 
                'null' => true
            ],
            'updated_at' => [
                'type' => 'datetime', 
                'null' => true
            ],
        ]);

        $this->forge->addKey('id', true);
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
