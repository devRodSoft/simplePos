<?php

use yii\db\Migration;

/**
 * Class m200418_105442_addClientesTable
 */
class m200418_105442_addClientesTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('clientes', [
            'id'           => $this->primaryKey(),
            'nombre'       => $this->string()->notNull(),
            'direccion'    => $this->string()->notNull(),
            'entreCalles'  => $this->string(),
            'codigoPostal' => $this->string(),
            'telefono'     => $this->string()->notNull(), 
            'notas'        => $this->string(),           
            'created_at'   => $this->integer()->notNull(),
            'updated_at'   => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200418_105442_addClientesTable cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200418_105442_addClientesTable cannot be reverted.\n";

        return false;
    }
    */
}
