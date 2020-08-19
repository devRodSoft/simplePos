<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DetalleVenta;

/**
 * DetalleVentaSearch represents the model behind the search form of `app\models\DetalleVenta`.
 */
class DetalleVentaSearch extends DetalleVenta
{
    public $username;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ventaId', 'productoId', 'created_at', 'updated_at'], 'integer'],
            [['username'], 'safe'],
            [['precio'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = DetalleVenta::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'ventaId' => $this->ventaId,
            'productoId' => $this->productoId,
            'precio' => $this->precio,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
    public function Corte($params, $id)
    {
        $query = DetalleVenta::find()->joinWith('venta v')
        ->where(['in', 'v.cajaId', $id])
        ->andWhere(['in', 'v.ventaApartado', 0]);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Lets do the same with country now
        $dataProvider->sort->attributes['venta'] = [
            'asc' => ['v.username' => SORT_ASC],
            'desc' => ['v.username' => SORT_DESC],
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'ventaId' => $this->ventaId,
            'productoId' => $this->productoId,
            'precio' => $this->precio,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ])

        ->andFilterWhere(['like', 'v.username', $this->username]);

        return $dataProvider;
    }
}
