<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class Device extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('devices');
        if ($table->exists()) {
            return;
        }

        $table
            ->addColumn('uid', 'string', ['limit' => 60])
            ->addColumn('app_id', 'string', ['limit' => 60])
            ->addColumn('language', 'string', ['limit' => 10])
            ->addColumn('os', 'string', ['limit' => 30])
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'null' => true])
            ->addColumn('expire_date', 'datetime', ['null' => true])
            ->addColumn('token', 'string', ['limit' => 35])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
