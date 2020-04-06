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
            'codidoBarras' => $this->string(),
            'descripcion'  => $this->string()->notNull(),
            'precio'       => $this->float()->notNull(),
            'precio1'      => $this->float(),
            'cantidad'     => $this->integer()->default(0),
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
