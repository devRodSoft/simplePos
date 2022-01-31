<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "abonos".
 *
 * @property int $id
 * @property int $clienteId
 * @property int $ventaId
 * @property int $userId
 * @property int $cajaId
 * @property float $abono
 * @property int $restante
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Cajas $caja
 * @property Clientes $cliente
 * @property User $user
 * @property Ventas $venta
 */
class Abonos extends \yii\db\ActiveRecord
{
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
        return 'abonos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clienteId', 'ventaId', 'userId', 'cajaId', 'abono', 'restante'], 'required'],
            [['clienteId', 'ventaId', 'userId', 'cajaId', 'abono','restante', 'created_at', 'updated_at'], 'integer'],
            [['cajaId'], 'exist', 'skipOnError' => true, 'targetClass' => Cajas::className(), 'targetAttribute' => ['cajaId' => 'id']],
            [['clienteId'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['clienteId' => 'id']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
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
            'clienteId' => 'Cliente ID',
            'ventaId' => 'Venta ID',
            'userId' => 'User ID',
            //'cajaId' => 'Caja ID',  
            'abono' => 'Abono',
            'restante' => 'Restante',
            'created_at' => 'Fecha',
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
     * Gets query for [[Cliente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Clientes::className(), ['id' => 'clienteId']);
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
