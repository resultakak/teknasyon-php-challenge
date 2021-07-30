<?php

declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class Subscriptions extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('subscriptions', ['id' => 'sid']);
        if ($table->exists()) {
            return;
        }

        $table
            ->addColumn('did', 'integer', ['limit' => MysqlAdapter::INT_BIG])
            ->addColumn('aid', 'integer', ['limit' => MysqlAdapter::INT_BIG])
            ->addColumn('receipt', 'string', ['limit' => 70])
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'null' => true])
            ->addColumn('expire_date', 'datetime', ['null' => true])
            ->addColumn('event', 'enum', ['values' => ['started', 'renewed', 'canceled']])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['did', 'aid'], [
                'name'  => 'sid_did_aid'
            ])
            ->addIndex('receipt', [
                'name'   => 'sid_receipt'
            ])
            ->create();
    }
}
