<?php

use yii\db\Migration;

/**
 * Class m200403_184313_sucursal
 */
class m200403_184313_sucursal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //Sucursales
        $this->createTable('sucursales', [
            //Datos del la sucursal
            'id'     => $this->primaryKey(),
            'nombre' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200403_184313_sucursal cannot be reverted.\n";

        return false;
    }
}
