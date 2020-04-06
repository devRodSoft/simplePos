<?php

use yii\db\Migration;

/**
 * Class m200403_184415_sucursal_producto
 */
class m200403_184415_sucursal_producto extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //sucursalProducto
        $this->createTable('sucursalProducto', [
            //Datos del producto
            'id'         => $this->primaryKey(),
            'sucursalId' => $this->string()->notNull(),
            'productoId' => $this->string()->notNull(),            
            'cantidad'   => $this->integer()->default(0),
        ]);

        // add foreign key for sucursal 
        $this->addForeignKey(
            'fk-sucursal-nombre-id',
            'sucursalProducto',
            'sucursalId',
            'sucursales',
            'id',
            'CASCADE'
        );

        // add foreign key for table productos
        $this->addForeignKey(
            'fk-sucursales-producto-id',
            'sucursalProducto',
            'productoId',
            'productos',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200403_184415_sucursal_producto cannot be reverted.\n";

        return false;
    }
}
