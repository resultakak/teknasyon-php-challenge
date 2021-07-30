<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UserMigration extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('credentials');
        if ($table->exists()) {
            return;
        }

        $table
            ->addColumn('name', 'string', ['limit' => 80])
            ->addColumn('password', 'string', ['limit' => 120])
            ->addColumn('created', 'datetime')
            ->create();
    }
}
