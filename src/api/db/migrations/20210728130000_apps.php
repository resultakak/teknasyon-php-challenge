<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Apps extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('apps');
        if ($table->exists()) {
            return;
        }

        $table
            ->addColumn('app_id', 'string', ['limit' => 60])
            ->addColumn('username', 'string', ['limit' => 60])
            ->addColumn('password', 'string', ['limit' => 60])
            ->addColumn('name', 'string', ['limit' => 60])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['app_id', 'username'], [
                'unique' => true,
                'name'   => 'apps_app_id'
            ])
            ->create();
    }
}
