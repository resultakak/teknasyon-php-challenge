<?php

declare(strict_types=1);

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
            ->addColumn('did', 'integer')
            ->addColumn('aid', 'integer')
            ->addColumn('token', 'string', ['limit' => 70])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['did', 'aid'], [
                'name' => 'daid_did_aid'
            ])
            ->create();

        $table
            ->addForeignKey(
                'did',
                'devices',
                'did',
            )
            ->addForeignKey(
                'aid',
                'apps',
                'aid',
            )
            ->save();
    }
}
