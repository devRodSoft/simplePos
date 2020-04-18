<?php

use yii\db\Migration;

/**
 * Class m200418_111726_addDetalleApartados
 */
class m200418_111726_addDetalleApartados extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('detalleApartados', [
            'id'           => $this->primaryKey(),
            'apartadoId'   => $this->integer()->notNull(),
            'productoId'   => $this->integer()->notNull(), 
            'cantidad'     => $this->integer()->notNull(),
            'precio'       => $this->float(), 

        ]);

        //add foreign key for table 'cajas'
        $this->addForeignKey(
            'fk-apartado-id',
            'detalleApartados',
            'apartadoId',
            'apartados',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-producto-id-apartados',
            'detalleApartados',
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
        echo "m200418_111726_addDetalleApartados cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200418_111726_addDetalleApartados cannot be reverted.\n";

        return false;
    }
    */
}
