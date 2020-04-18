<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "abonos".
 *
 * @property int $id
 * @property int $clienteId
 * @property int $apartadoId
 * @property int $userId
 * @property int $cajaId
 * @property float $abono
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Apartados $apartado
 * @property Cajas $caja
 * @property Clientes $cliente
 * @property User $user
 */
class Abonos extends \yii\db\ActiveRecord
{
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
            [['clienteId', 'apartadoId', 'userId', 'cajaId', 'abono', 'created_at', 'updated_at'], 'required'],
            [['clienteId', 'apartadoId', 'userId', 'cajaId', 'created_at', 'updated_at'], 'integer'],
            [['abono'], 'number'],
            [['apartadoId'], 'exist', 'skipOnError' => true, 'targetClass' => Apartados::className(), 'targetAttribute' => ['apartadoId' => 'id']],
            [['cajaId'], 'exist', 'skipOnError' => true, 'targetClass' => Cajas::className(), 'targetAttribute' => ['cajaId' => 'id']],
            [['clienteId'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['clienteId' => 'id']],
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
            'clienteId' => 'Cliente ID',
            'apartadoId' => 'Apartado ID',
            'userId' => 'User ID',
            'cajaId' => 'Caja ID',
            'abono' => 'Abono',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
}
