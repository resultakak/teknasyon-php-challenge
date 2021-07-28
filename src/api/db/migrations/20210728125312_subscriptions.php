<?php

declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class Subscriptions extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('subscriptions', ['id' => 'subscribe_id']);
        if ($table->exists()) {
            return;
        }

        $table
            ->addColumn('device_id', 'integer', ['limit' => MysqlAdapter::INT_BIG])
            ->addColumn('receipt', 'string', ['limit' => 60])
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'null' => true])
            ->addColumn('expire_date', 'datetime', ['null' => true])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex('receipt', [
                    'name'   => 'subs_receipt_hash'
                ])
            ->addIndex(['device_id'], [
                    'name'  => 'subs_device_id',
                    'order' => ['device_id' => 'DESC']
                ])
            ->create();
    }
}
