<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
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
            ->addColumn('aid', 'integer', ['limit' => MysqlAdapter::INT_BIG])
            ->addColumn('username', 'string', ['limit' => 70])
            ->addColumn('password', 'string', ['limit' => 70])
            ->addColumn('platform', 'enum', ['values' => ['IOS', 'ANDROID']])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['aid', 'username'], [
                'unique' => true,
                'name'   => 'acid_aid'
            ])
            ->addForeignKey(
                'aid',
                'apps',
                'aid',
                ['update' => 'NO_ACTION', 'constraint' => 'credential_app_aid']
            )
            ->create();
    }
}
