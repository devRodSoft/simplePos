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
            //Datos del producto
            'id'              => $this->primaryKey(),
            'cajaId'          => $this->integer()->notNull(),
            'sucursalId'      => $this->integer()->notNull(),
            'userId'          => $this->integer()->notNull(),            
            'retiroCantidad'  => $this->integer()->notNull(),
        ]);
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
