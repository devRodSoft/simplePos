<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;;

/**
 * This is the model class for table "salidas".
 *
 * @property int $id
 * @property int $cajaId
 * @property int $sucursalId
 * @property int $userId
 * @property int $retiroCantidad
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Cajas $caja
 * @property Sucursales $sucursal
 * @property User $user
 */
class Salidas extends \yii\db\ActiveRecord
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
        return 'salidas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cajaId', 'sucursalId', 'userId', 'retiroCantidad', 'concepto'], 'required'],
            [['cajaId', 'sucursalId', 'userId', 'retiroCantidad', 'created_at', 'updated_at'], 'integer'],
            [['cajaId'], 'exist', 'skipOnError' => true, 'targetClass' => Cajas::className(), 'targetAttribute' => ['cajaId' => 'id']],
            [['sucursalId'], 'exist', 'skipOnError' => true, 'targetClass' => Sucursales::className(), 'targetAttribute' => ['sucursalId' => 'id']],
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
            'cajaId' => 'Caja ID',
            'sucursalId' => 'Sucursal ID',
            'userId' => 'User ID',
            'concepto' => 'Concepto',
            'retiroCantidad' => 'Retiro Cantidad',
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
     * Gets query for [[Sucursal]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSucursal()
    {
        return $this->hasOne(Sucursales::className(), ['id' => 'sucursalId']);
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
