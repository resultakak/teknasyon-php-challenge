<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class DeviceApps extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('device_apps', ['id' => 'daid']);
        if ($table->exists()) {
            return;
        }

        $table
            ->addColumn('did', 'integer', ['limit' => MysqlAdapter::INT_BIG])
            ->addColumn('aid', 'integer', ['limit' => MysqlAdapter::INT_BIG])
            ->addColumn('token', 'string', ['limit' => 70])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['did', 'aid'], [
                'unique' => true,
                'name'   => 'daid_did_aid'
            ])
            ->addForeignKey(
                'did',
                'devices',
                'did',
                ['delete' => 'SET_NULL', 'update' => 'NO_ACTION']
            )
            ->addForeignKey(
                'aid',
                'apps',
                'aid',
                ['delete' => 'SET_NULL', 'update' => 'NO_ACTION']
            )
            ->create();
    }
}
