<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sucursalProducto".
 *
 * @property int $id
 * @property int $sucursalId
 * @property int $productoId
 * @property int|null $cantidad
 */
class SucursalProducto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sucursalProducto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sucursalId', 'productoId'], 'required'],
            [['sucursalId', 'productoId', 'cantidad'], 'integer'],
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
        ];
    }
}
