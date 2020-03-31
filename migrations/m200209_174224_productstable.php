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
        //Productos
        $this->createTable('productos', [
            //Datos del producto
            'id' => $this->primaryKey(),
            'codidoBarras' => $this->string()->notNull(),
            'descripcion' => $this->string()->notNull(),
            'precio' => $this->integer()->notNull(),
            'cantidad' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200209_174224_productstable cannot be reverted.\n";

        return false;
    }
}
