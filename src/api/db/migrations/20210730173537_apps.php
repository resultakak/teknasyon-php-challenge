<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Apps extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('apps', ['id' => 'aid']);
        if ($table->exists()) {
            return;
        }

        $table
            ->addColumn('app_id', 'string', ['limit' => 70])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['app_id'], [
                'unique' => true,
                'name'   => 'aid_app_id'
            ])
            ->create();
    }
}
