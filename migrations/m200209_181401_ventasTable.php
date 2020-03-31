<?php

use yii\db\Migration;

/**
 * Class m200209_181401_ventasTable
 */
class m200209_181401_ventasTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //Ventas
        $this->createTable('ventas', [
            //Datos del producto
            'id' => $this->primaryKey(),
            'total' => $this->float()->notNull(),
            'descuento' => $this->float(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200209_181401_ventasTable cannot be reverted.\n";

        return false;
    }
}
