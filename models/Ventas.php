<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ventas".
 *
 * @property int $id
 * @property float $total
 * @property float|null $descuento
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Detalleventa[] $detalleventas
 */
class Ventas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ventas';
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
           
        ];
    }
 
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total'], 'required'],
            [['total', 'descuento'], 'number'],
            [['updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'total' => 'Total',
            'descuento' => 'Descuento',
            'created_at' => 'Fecha Venta',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Detalleventas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleventas()
    {
        return $this->hasMany(Detalleventa::className(), ['ventaId' => 'id']);
    }
}
