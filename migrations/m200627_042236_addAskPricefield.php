<?php

use yii\db\Migration;

/**
 * Class m200627_042236_addAskPricefield
 */
class m200627_042236_addAskPricefield extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('productos', 'preguntarPrecio', $this->integer()->notNull()->after('cantidad')->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200627_042236_addAskPricefield cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200627_042236_addAskPricefield cannot be reverted.\n";

        return false;
    }
    */
}
