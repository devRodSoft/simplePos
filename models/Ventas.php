<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "ventas".
 *
 * @property int $id
 * @property float $total
 * @property float|null $descuento
 * @property int|null $userId
 * @property int $cajaId
 * @property int $tipoVenta
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Cajas $caja
 * @property User $user
 */
class Ventas extends \yii\db\ActiveRecord
{

    const EFECTIVO = 0;
    const TARGETA  = 1;

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
    public static function tableName()
    {
        return 'ventas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total', 'cajaId'], 'required'],
            [['total', 'descuento'], 'number'],
            [['descripcion'], 'string'],
            //[['ventaApartado', 'liquidado'], 'integer'],
            [['userId', 'cajaId', 'tipoVenta', 'created_at', 'updated_at'], 'integer'],
            [['cajaId'], 'exist', 'skipOnError' => true, 'targetClass' => Cajas::className(), 'targetAttribute' => ['cajaId' => 'id']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
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
            'userId' => 'User ID',
            'cajaId' => 'Caja ID',
            'descripcion' => 'Detalle',
            'tipoVenta' => "tipoVenta",
            //'ventaApartado' => "Venta",
            'liquidado' => "liquidado",
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Caja]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCaja()
    {
        return $this->hasOne(Cajas::className(), ['id' => 'cajaId']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
}
