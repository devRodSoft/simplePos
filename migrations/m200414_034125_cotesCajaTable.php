<?php

use yii\db\Migration;

/**
 * Class m200414_034125_cotesCajaTable
 */
class m200414_034125_cotesCajaTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //table cajas
        $this->createTable('cajas', [
            //Datos de la Venta
            'id'           => $this->primaryKey(),
            'sucursalId'   => $this->integer()->notNull(),
            'userId'       => $this->integer()->notNull(),
            'saldoInicial' => $this->float()->notNull(),
            'saldoFinal'   => $this->float(),
            'isOpen'       => $this->boolean()->notNull()->defaultValue(true),
            'created_at'   => $this->integer()->notNull(),
            'apertura'     => $this->dateTime()->notNull(),
            'cierre'       => $this->dateTime()->notNull(),
            'updated_at'   => $this->integer()->notNull(),
        ]);

        // add foreign key for table `venta`
        $this->addForeignKey(
            'fk-caja-sucursal-id',
            'cajas',
            'sucursalId',
            'sucursales',
            'id',
            'CASCADE'
        );

        // add foreign key for table `venta`
        $this->addForeignKey(
            'fk-venta-detalle-producto-id',
            'cajas',
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
        echo "m200414_034125_cotesCajaTable cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200414_034125_cotesCajaTable cannot be reverted.\n";

        return false;
    }
    */
}
