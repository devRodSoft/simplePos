<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "apartados".
 *
 * @property int $id
 * @property float $total
 * @property int $userId
 * @property int $liquidado
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Abonos[] $abonos
 * @property Detalleapartados[] $detalleapartados
 */
class Apartados extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apartados';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total', 'userId', 'created_at', 'updated_at'], 'required'],
            [['total'], 'number'],
            [['userId', 'liquidado', 'created_at', 'updated_at'], 'integer'],
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
            'userId' => 'User ID',
            'liquidado' => 'Liquidado',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Abonos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAbonos()
    {
        return $this->hasMany(Abonos::className(), ['apartadoId' => 'id']);
    }

    /**
     * Gets query for [[Detalleapartados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleapartados()
    {
        return $this->hasMany(Detalleapartados::className(), ['apartadoId' => 'id']);
    }
}
