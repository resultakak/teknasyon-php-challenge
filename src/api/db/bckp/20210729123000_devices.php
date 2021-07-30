<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Devices extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('devices', ['id' => 'did']);
        if ($table->exists()) {
            return;
        }

        $table
            ->addColumn('uid', 'string', ['limit' => 70])
            ->addColumn('language', 'string', ['limit' => 20])
            ->addColumn('platform', 'enum', ['values' => ['IOS', 'ANDROID']])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['uid'], [
                'unique' => true,
                'name'   => 'did_uid'
            ])
            ->create();
    }
}
