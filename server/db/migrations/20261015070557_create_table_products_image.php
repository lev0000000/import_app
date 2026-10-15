<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableProductsImage extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('product_images');

        $table
            ->addColumn('product_id', 'integer', [
                'signed' => false,
                'null' => false,
            ])
            ->addColumn('url', 'text', [
                'null' => false,
            ])
            ->addColumn('path', 'string', [
                'limit' => 1024,
                'null' => false,
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