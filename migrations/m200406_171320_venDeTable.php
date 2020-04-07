<?php

use yii\db\Migration;

/**
 * Class m200406_171320_venDeTable
 */
class m200406_171320_venDeTable extends Migration
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
        echo "m200406_171320_venDeTable cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200406_171320_venDeTable cannot be reverted.\n";

        return false;
    }
    */
}
