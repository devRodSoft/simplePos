<?php

use yii\db\Migration;

/**
 * Class m200406_133514_ventaTable
 */
class m200406_133514_ventaTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //Ventas
        $this->createTable('ventas', [
            //Datos de la Venta
            'id'         => $this->primaryKey(),
            'total'      => $this->float()->notNull(),
            'descuento'  => $this->float(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200406_133514_ventaTable cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200406_133514_ventaTable cannot be reverted.\n";

        return false;
    }
    */
}
