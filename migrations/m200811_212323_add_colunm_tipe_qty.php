<?php

use yii\db\Migration;

/**
 * Class m200811_212323_add_colunm_tipe_qty
 */
class m200811_212323_add_colunm_tipe_qty extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('productos', 'type', $this->integer()->notNull()->after('cantidad'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200811_212323_add_colunm_tipe_qty cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200811_212323_add_colunm_tipe_qty cannot be reverted.\n";

        return false;
    }
    */
}
