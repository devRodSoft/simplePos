<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "clientes".
 *
 * @property int $id
 * @property string $nombre
 * @property string $direccion
 * @property string|null $entreCalles
 * @property string|null $codigoPostal
 * @property string $telefono
 * @property string|null $notas
 * @property int $created_at
 * @property int $updated_at
 */
class Clientes extends \yii\db\ActiveRecord
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
        return 'clientes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'direccion', 'telefono'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['nombre', 'direccion', 'entreCalles', 'codigoPostal', 'telefono', 'notas'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'direccion' => 'Direccion',
            'entreCalles' => 'Entre Calles',
            'codigoPostal' => 'Codigo Postal',
            'telefono' => 'Telefono',
            'notas' => 'Notas',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
