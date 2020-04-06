<?php

use yii\db\Migration;

/**
 * Class m200406_133549_ventaDetalleTabl
 */
class m200406_133549_ventaDetalleTabl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        //Detalle ventas table 
        $this->createTable('detalleVenta', [
            'id'         => $this->primaryKey(),
            'ventaId'    => $this->integer()->notNull(), 
            'productoId' => $this->integer()->notNull(), 
            'precio'     => $this->float(),       
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
        echo "m200406_133549_ventaDetalleTabl cannot be reverted.\n";

        return false;
    }
}
