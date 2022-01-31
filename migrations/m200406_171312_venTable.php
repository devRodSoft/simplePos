<?php

use yii\db\Migration;

/**
 * Class m200406_171312_venTable
 */
class m200406_171312_venTable extends Migration
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
            'userId'     => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // add foreign key for table `venta`
        $this->addForeignKey(
            'fk-who-do-the-self-id',
            'ventas',
            'userId',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200406_171312_venTable cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200406_171312_venTable cannot be reverted.\n";

        return false;
    }
    */
}
