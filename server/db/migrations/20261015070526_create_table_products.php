<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableProducts extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('products');

        $table
            ->addColumn('external_code', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'null' => true,
            ])
            ->addColumn('price', 'decimal', [
                'precision' => 12,
                'scale' => 2,
                'null' => false,
            ])
            ->addColumn('discount', 'decimal', [
                'precision' => 7,
                'scale' => 2,
                'null' => false,
                'default' => 0,
            ])
            ->addIndex(['external_code'], [
                'unique' => true,
                'name' => 'idx_products_external_code',
            ])
            ->create();
    }
}