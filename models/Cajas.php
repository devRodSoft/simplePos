<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cajas".
 *
 * @property int $id
 * @property int $sucursalId
 * @property int $userId
 * @property float $saldoInicial
 * @property float $saldoFinal
 * @property int $isOpen
 * @property int $created_at
 * @property string $apertura
 * @property string $cierre
 * @property int $updated_at
 *
 * @property Sucursales $sucursal
 * @property User $user
 * @property Ventas[] $ventas
 */
class Cajas extends \yii\db\ActiveRecord
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
        return 'cajas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sucursalId', 'userId', 'saldoInicial', 'apertura'], 'required'],
            [['sucursalId', 'userId', 'isOpen', 'created_at', 'updated_at'], 'integer'],
            [['saldoInicial', 'saldoFinal'], 'number'],
            [['apertura', 'cierre'], 'safe'],
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
            'sucursalId' => 'Sucursal ID',
            'userId' => 'User ID',
            'saldoInicial' => 'Saldo inicial',
            'saldoFinal' => 'Saldo final',
            'isOpen' => 'Is Open',
            'created_at' => 'Fecha de apertura',
            'apertura' => 'Apertura',
            'cierre' => 'Cierre',
            'updated_at' => 'Updated At',
        ];
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

    /**
     * Gets query for [[Ventas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVentas()
    {
        return $this->hasMany(Ventas::className(), ['cajaId' => 'id']);
    }

    public function getOpenCaja() {
        return $this->find()->where(['=', 'isOpen', 1])->andWhere(['=', 'sucursalId',  Yii::$app->user->identity->sucursalId])->all();
    }

    public function getIdOpenCaja() {
        return Cajas::find()->select("id")->where(['=', 'isOpen', 1])->andWhere(['=', 'sucursalId',  Yii::$app->user->identity->sucursalId])->one();
    }

    public function canClose($id) {
        return  Cajas::find()->where(['=', 'id', $id])->one()->isOpen == 1 ? true : false; 
    }
}
