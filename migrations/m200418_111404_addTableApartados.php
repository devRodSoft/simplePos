<?php

use yii\db\Migration;

/**
 * Class m200418_111404_addTableApartados
 */
class m200418_111404_addTableApartados extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('apartados', [
            'id'           => $this->primaryKey(),
            'total'        => $this->float()->notNull(),
            'userId'       => $this->integer()->notNull(),
            'liquidado'    => $this->integer()->notNull()->defaultValue(0),
            'created_at'   => $this->integer()->notNull(),
            'updated_at'   => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200418_111404_addTableApartados cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200418_111404_addTableApartados cannot be reverted.\n";

        return false;
    }
    */
}
