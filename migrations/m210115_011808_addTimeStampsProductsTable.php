<?php

use yii\db\Migration;

/**
 * Class m210115_011808_addTimeStampsProductsTable
 */
class m210115_011808_addTimeStampsProductsTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('productos', 'created_at', $this->integer()->notNull()->after('preguntarPrecio'));
        $this->addColumn('productos', 'updated_at', $this->integer()->notNull()->after('created_at'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210115_011808_addTimeStampsProductsTable cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210115_011808_addTimeStampsProductsTable cannot be reverted.\n";

        return false;
    }
    */
}
