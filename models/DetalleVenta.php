<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "detalleventa".
 *
 * @property int $id
 * @property int $ventaId
 * @property int $productoId
 * @property float|null $precio
 * @property int |null $cantidad
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Productos $producto
 * @property Ventas $venta
 */
class Detalleventa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalleventa';
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ventaId', 'productoId'], 'required'],
            [['ventaId', 'productoId', 'cantidad', 'created_at', 'updated_at'], 'integer'],
            [['precio'], 'number'],
            [['productoId'], 'exist', 'skipOnError' => true, 'targetClass' => Productos::className(), 'targetAttribute' => ['productoId' => 'id']],
            [['ventaId'], 'exist', 'skipOnError' => true, 'targetClass' => Ventas::className(), 'targetAttribute' => ['ventaId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ventaId' => 'Venta ID',
            'productoId' => 'Producto ID',
            'precio' => 'Precio',
            'Cantidad' => 'Cantidad',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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

    /**
     * Gets query for [[Venta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVenta()
    {
        return $this->hasOne(Ventas::className(), ['id' => 'ventaId']);
    }
}
