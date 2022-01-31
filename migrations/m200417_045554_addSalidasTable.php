<?php

use yii\db\Migration;

/**
 * Class m200417_045554_addSalidasTable
 */
class m200417_045554_addSalidasTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //sucursalProducto
        $this->createTable('salidas', [
            //Datos del la salida
            'id'              => $this->primaryKey(),
            'cajaId'          => $this->integer()->notNull(),
            'sucursalId'      => $this->integer()->notNull(),
            'userId'          => $this->integer()->notNull(),            
            'retiroCantidad'  => $this->integer()->notNull(),
            'created_at'      => $this->integer()->notNull(),
            'updated_at'      => $this->integer()->notNull(),
        ]);

        // add foreign key for table `venta`
        $this->addForeignKey(
            'fk-user-salidas',
            'salidas',
            'userId',
            'user',
            'id',
            'CASCADE'
        );

        //add foreign key for table 'sucursales'
        $this->addForeignKey(
            'fk-sucursales-salidas',
            'salidas',
            'sucursalId',
            'sucursales',
            'id',
            'CASCADE'
        );

        //add foreign key for table 'cajas'
        $this->addForeignKey(
            'fk-cajas-salidas',
            'salidas',
            'cajaId',
            'cajas',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200417_045554_addSalidasTable cannot be reverted.\n";

        return false;
    }
}
