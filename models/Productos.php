<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "productos".
 *
 * @property int $id
 * @property string $codidoBarras
 * @property string $descripcion
 * @property int $costo
 * @property int $precio
 * @property int $precio1
 * @property string $cantidad
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Detalleventa[] $detalleventas
 */
class Productos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productos';
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
            [['descripcion', 'precio', 'cantidad'], 'required'],
            [['cantidad', 'preguntarPrecio', 'created_at', 'updated_at'], 'integer'],
            [['costo', 'precio', 'precio1'], 'number'],
            [['codidoBarras', 'descripcion'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codidoBarras' => 'Código',
            'descripcion' => 'Descripción',
            'costo' => 'Costo',
            'precio' => 'Precio',
            'precio1' => 'Precio 1',
            'cantidad' => 'Cantidad',
            'preguntarPrecio' => 'Preguntar Precio',
            'created_at' => 'Created At',
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
        return $this->hasMany(Detalleventa::className(), ['productoId' => 'id']);
    }
}
