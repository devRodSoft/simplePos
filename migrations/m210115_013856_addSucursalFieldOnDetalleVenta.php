<?php

use yii\db\Migration;

/**
 * Class m210115_013856_addSucursalFieldOnDetalleVenta
 */
class m210115_013856_addSucursalFieldOnDetalleVenta extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('detalleventa', 'sucursalId', $this->integer()->notNull()->after('cantidad'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210115_013856_addSucursalFieldOnDetalleVenta cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210115_013856_addSucursalFieldOnDetalleVenta cannot be reverted.\n";

        return false;
    }
    */
}
