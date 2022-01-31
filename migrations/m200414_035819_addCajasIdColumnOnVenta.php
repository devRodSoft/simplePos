<?php

use yii\db\Migration;

/**
 * Class m200414_035819_addCajasIdColumnOnVenta
 */
class m200414_035819_addCajasIdColumnOnVenta extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('ventas', 'cajaId', $this->integer()->notNull()->after('userId'));

        // add foreign key for table `venta`
        $this->addForeignKey(
            'fk-caja-venta-id',
            'ventas',
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
        echo "m200414_035819_addCajasIdColumnOnVenta cannot be reverted.\n";

        return false;
    }
}
