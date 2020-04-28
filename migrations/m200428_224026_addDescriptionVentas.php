<?php

use yii\db\Migration;

/**
 * Class m200428_224026_addDescriptionVentas
 */
class m200428_224026_addDescriptionVentas extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ventas', 'descripcion', $this->string()->after('userId'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200428_224026_addDescriptionVentas cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200428_224026_addDescriptionVentas cannot be reverted.\n";

        return false;
    }
    */
}
