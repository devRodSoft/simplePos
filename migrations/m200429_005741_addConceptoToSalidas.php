<?php

use yii\db\Migration;

/**
 * Class m200429_005741_addConceptoToSalidas
 */
class m200429_005741_addConceptoToSalidas extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('salidas', 'concepto', $this->string()->notNull()->after('userId'));
    
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200429_005741_addConceptoToSalidas cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200429_005741_addConceptoToSalidas cannot be reverted.\n";

        return false;
    }
    */
}
