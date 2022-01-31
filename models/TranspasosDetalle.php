<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalletranspasos".
 *
 * @property int $id
 * @property int $transpasoId
 * @property int $productoId
 * @property int $cantidad
 * @property int $qtyFrom
 * @property int $qtyFinal
 *
 * @property Sucursales $qtyFrom
 * @property Transpasos $transpaso
 * @property Productos $producto
 */
class TranspasosDetalle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalletranspasos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transpasoId', 'productoId', 'cantidad', 'qtyFrom', 'qtyFinal'], 'required'],
            [['transpasoId', 'productoId', 'cantidad', 'qtyFrom', 'qtyFinal'], 'integer'],
            [['qtyFrom'], 'exist', 'skipOnError' => true, 'targetClass' => Sucursales::className(), 'targetAttribute' => ['qtyFrom' => 'id']],
            [['qtyFinal'], 'exist', 'skipOnError' => true, 'targetClass' => Sucursales::className(), 'targetAttribute' => ['qtyFinal' => 'id']],
            [['transpasoId'], 'exist', 'skipOnError' => true, 'targetClass' => Transpasos::className(), 'targetAttribute' => ['transpasoId' => 'id']],
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
            'transpasoId' => 'Transpaso ID',
            'productoId' => 'Producto ID',
            'cantidad' => 'Cantidad',
            'qtyFrom' => 'Qty From',
            'qtyFinal' => 'Qty Final',
        ];
    }

    /**
     * Gets query for [[QtyFrom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrigen()
    {
        return $this->hasOne(Sucursales::className(), ['id' => 'qtyFrom']);
    }


    /**
     * Gets query for [[QtyFinal]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDestino()
    {
        return $this->hasOne(Sucursales::className(), ['id' => 'qtyFinal']);
    }
    /**
     * Gets query for [[Transpaso]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranspaso()
    {
        return $this->hasOne(Transpasos::className(), ['id' => 'transpasoId']);
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
