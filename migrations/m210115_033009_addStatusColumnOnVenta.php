<?php

use yii\db\Migration;

/**
 * Class m210115_033009_addStatusColumnOnVenta
 */
class m210115_033009_addStatusColumnOnVenta extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ventas', 'status', $this->integer()->notNull()->defaultValue(0)->after('cajaId'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210115_033009_addStatusColumnOnVenta cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210115_033009_addStatusColumnOnVenta cannot be reverted.\n";

        return false;
    }
    */
}
