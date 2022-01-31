<?php

use yii\db\Migration;

/**
 * Class m200418_112418_abonosTable
 */
class m200418_112418_abonosTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('abonos', [
            'id'           => $this->primaryKey(),
            'clienteId'    => $this->integer()->notNull(),
            'ventaId'   => $this->integer()->notNull(),
            'userId'       => $this->integer()->notNull(),
            'cajaId'       => $this->integer()->notNull(),
            'abono'        => $this->float()->notNull(),
            'created_at'   => $this->integer()->notNull(),
            'updated_at'   => $this->integer()->notNull()
        ]);

        //add foreign key for table 'cajas'
        $this->addForeignKey(
            'fk-cliente-id-abonos',
            'abonos',
            'clienteId',
            'clientes',
            'id',
            'CASCADE'
        );

        //add foreign key for table 'cajas'
        $this->addForeignKey(
            'fk-venta-id-abonos',
            'abonos',
            'ventaId',
            'ventas',
            'id',
            'CASCADE'
        );

        //add foreign key for table 'cajas'
        $this->addForeignKey(
            'fk-user-id-abonos',
            'abonos',
            'userId',
            'user',
            'id',
            'CASCADE'
        );

        //add foreign key for table 'cajas'
        $this->addForeignKey(
            'fk-caja-id-abonos',
            'abonos',
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
        echo "m200418_112418_abonosTable cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200418_112418_abonosTable cannot be reverted.\n";

        return false;
    }
    */
}
