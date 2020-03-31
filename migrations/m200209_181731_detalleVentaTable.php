<?php

use yii\db\Migration;

/**
 * Class m200209_181731_detalleVentaTable
 */
class m200209_181731_detalleVentaTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('detalleVenta', [
            'id' => $this->primaryKey(),
            'ventaId' => $this->integer()->notNull(), 
            'productoId' => $this->integer()->notNull(), 
            'precio' => $this->float(),       
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // add foreign key for table `venta`
        $this->addForeignKey(
            'fk-venta-detalle-venta-id',
            'detalleVenta',
            'ventaId',
            'ventas',
            'id',
            'CASCADE'
        );

        // add foreign key for table `venta`
        $this->addForeignKey(
            'fk-venta-detalle-producto-id',
            'detalleVenta',
            'productoId',
            'productos',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200209_181731_detalleVentaTable cannot be reverted.\n";

        return false;
    }
}
