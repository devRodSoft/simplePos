<?php

use yii\db\Migration;

/**
 * Class m200529_194459_ventaApartado
 */
class m200529_194459_ventaApartado extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ventas', 'liquidado', $this->integer()->notNull()->after('cajaId'));
        $this->addColumn('ventas', 'ventaApartado', $this->integer()->notNull()->after('liquidado'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200529_194459_ventaApartado cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200529_194459_ventaApartado cannot be reverted.\n";

        return false;
    }
    */
}
