<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sucursalproducto".
 *
 * @property int $id
 * @property int $sucursalId
 * @property int $productoId
 * @property int|null $cantidad
 *
 * @property Sucursales $sucursal
 * @property Productos $producto
 */
class SucursalProducto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sucursalproducto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sucursalId', 'productoId'], 'required'],
            [['sucursalId', 'productoId', 'cantidad', 'apartado'], 'integer'],
            [['sucursalId'], 'exist', 'skipOnError' => true, 'targetClass' => Sucursales::className(), 'targetAttribute' => ['sucursalId' => 'id']],
            [['productoId'], 'exist', 'skipOnError' => true, 'targetClass' => Productos::className(), 'targetAttribute' => ['productoId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sucursalId' => 'Sucursal ID',
            'productoId' => 'Producto ID',
            'cantidad' => 'Cantidad',
            'apartado' => 'Apartados',
        ];
    }

    /**
     * Gets query for [[Sucursal]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSucursal()
    {
        return $this->hasOne(Sucursales::className(), ['id' => 'sucursalId']);
    }

    /**
     * Gets query for [[Producto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Productos::className(), ['id' => 'productoId']);
    }
}
