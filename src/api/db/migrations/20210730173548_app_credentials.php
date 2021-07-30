<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AppCredentials extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('app_credentials', ['id' => 'acid']);
        if ($table->exists()) {
            return;
        }

        $table
            ->addColumn('aid', 'integer')
            ->addColumn('username', 'string', ['limit' => 70])
            ->addColumn('password', 'string', ['limit' => 70])
            ->addColumn('platform', 'enum', ['values' => ['IOS', 'ANDROID']])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['aid', 'username'], [
                'unique' => true,
                'name'   => 'acid_aid'
            ])
            ->create();

        $table
            ->addForeignKey(
                'aid',
                'apps',
                'aid'
            )
            ->save();

    }
}
