<?php

use yii\db\Migration;

/**
 * Class m200406_174935_addCostoProductable
 */
class m200406_174935_addCostoProductable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('productos', 'costo', $this->integer()->notNull()->after('descripcion'));
        $this->addColumn('productos', 'precio1', $this->float()->notNull()->after('precio'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200406_174935_addCostoProductable cannot be reverted.\n";

        return false;
    }
}
