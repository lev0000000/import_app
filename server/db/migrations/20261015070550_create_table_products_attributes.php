<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableProductsAttributes extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('product_attributes');

        $table
            ->addColumn('product_id', 'integer', [
                'signed' => false,
                'null' => false,
            ])
            ->addColumn('key', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('value', 'text', [
                'null' => true,
            ])
            ->addIndex(['product_id'])
            ->addForeignKey(
                'product_id',
                'products',
                'id',
                [
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ]
            )
            ->create();
    }
}