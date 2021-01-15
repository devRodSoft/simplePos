<?php

use yii\db\Migration;

/**
 * Class m210115_012100_addFieldSucursalProducto
 */
class m210115_012100_addFieldSucursalProducto extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('sucursalproducto', 'productoApartado', $this->integer()->notNull()->defaultValue(0)->after('cantidad'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210115_012100_addFieldSucursalProducto cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210115_012100_addFieldSucursalProducto cannot be reverted.\n";

        return false;
    }
    */
}
