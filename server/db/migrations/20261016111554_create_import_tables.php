<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateImportTables extends AbstractMigration
{
    public function change(): void
    {
        $this->table('import_jobs', [
            'id' => false,
            'primary_key' => ['id'],
        ])
            ->addColumn('id', 'string', [
                'limit' => 36,
                'null' => false,
            ])
            ->addColumn('filename', 'string', ['limit' => 255])
            ->addColumn('status', 'string', [
                'limit' => 30,
                'default' => 'pending',
            ])
            ->addColumn('total_rows', 'integer', ['default' => 0])
            ->addColumn('success_rows', 'integer', ['default' => 0])
            ->addColumn('failed_rows', 'integer', ['default' => 0])
            ->addColumn('created_at', 'datetime')
            ->addColumn('finished_at', 'datetime', ['null' => true])
            ->create();

        $this->table('import_errors')
            ->addColumn('job_id', 'string', ['limit' => 36])
            ->addColumn('row_number', 'integer')
            ->addColumn('external_code', 'string', [
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('field', 'string', ['limit' => 100])
            ->addColumn('message', 'text')
            ->addIndex(['job_id'])
            ->addForeignKey('job_id', 'import_jobs', 'id', [
                'delete' => 'CASCADE',
                'update' => 'NO_ACTION',
            ])
            ->create();
    }
}
