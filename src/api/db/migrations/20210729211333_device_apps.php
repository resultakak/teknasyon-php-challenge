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
                'name'   => 'daid_did_aid'
            ])
            ->addForeignKey(
                'did',
                'devices',
                'did',
                ['update' => 'NO_ACTION', 'constraint' => 'deapp_device_did']
            )
            ->addForeignKey(
                'aid',
                'apps',
                'aid',
                ['update' => 'NO_ACTION', 'constraint' => 'deapp_app_aid']
            )
            ->create();
    }
}
