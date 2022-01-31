<?php

use yii\db\Migration;

/**
 * Class m200418_075137_addTipoVentaColumn
 */
class m200418_075137_addTipoVentaColumn extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ventas', 'tipoVenta', $this->integer()->notNull()->after('userId'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200418_075137_addTipoVentaColumn cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200418_075137_addTipoVentaColumn cannot be reverted.\n";

        return false;
    }
    */
}
