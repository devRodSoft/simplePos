<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalleapartados".
 *
 * @property int $id
 * @property int $apartadoId
 * @property int $productoId
 * @property int $cantidad
 * @property float|null $precio
 *
 * @property Apartados $apartado
 * @property Productos $producto
 */
class Detalleapartados extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalleapartados';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apartadoId', 'productoId', 'cantidad'], 'required'],
            [['apartadoId', 'productoId', 'cantidad'], 'integer'],
            [['precio'], 'number'],
            [['apartadoId'], 'exist', 'skipOnError' => true, 'targetClass' => Apartados::className(), 'targetAttribute' => ['apartadoId' => 'id']],
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
            'apartadoId' => 'Apartado ID',
            'productoId' => 'Producto ID',
            'cantidad' => 'Cantidad',
            'precio' => 'Precio',
        ];
    }

    /**
     * Gets query for [[Apartado]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApartado()
    {
        return $this->hasOne(Apartados::className(), ['id' => 'apartadoId']);
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
