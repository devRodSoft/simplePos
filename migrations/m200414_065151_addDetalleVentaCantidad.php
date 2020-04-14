<?php

use yii\db\Migration;

/**
 * Class m200414_065151_addDetalleVentaCantidad
 */
class m200414_065151_addDetalleVentaCantidad extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('detalleVenta', 'cantidad', $this->integer()->notNull()->after('precio'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200414_065151_addDetalleVentaCantidad cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200414_065151_addDetalleVentaCantidad cannot be reverted.\n";

        return false;
    }
    */
}
