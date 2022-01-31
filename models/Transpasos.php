<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "transpasos".
 *
 * @property int $id
 * @property int|null $userId
 * @property int $userOkId
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 *
 * @property Detalletranspasos[] $detalletranspasos
 * @property User $user
 */
class Transpasos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transpasos';
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
            [['userId', 'userOkId', 'created_at', 'updated_at', 'status'], 'integer'],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
            [['userOkId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userOkId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'Mando',
            'userOkId' => 'Recibe',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Detalletranspasos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetalletranspasos()
    {
        return $this->hasMany(Detalletranspasos::className(), ['transpasoId' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMando()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
        /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecibe()
    {
        return $this->hasOne(User::className(), ['id' => 'userOkId']);
    }
}
