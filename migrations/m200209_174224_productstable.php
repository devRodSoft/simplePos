<?php

use yii\db\Migration;

/**
 * Class m200209_174224_productstable
 */
class m200209_174224_productstable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200209_174224_productstable cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200209_174224_productstable cannot be reverted.\n";

        return false;
    }
    */
}
