<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SucursalProducto;

/**
 * SucursalProductoSearch represents the model behind the search form of `app\models\SucursalProducto`.
 */
class SucursalProductoSearch extends SucursalProducto
{
    public $producto;
    public $barcode;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sucursalId', 'productoId', 'cantidad'], 'integer'],
            [['barcode','producto'], 'safe'],
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
        $query = SucursalProducto::find();

        $query->joinWith(['producto']);
        // add conditions that should always apply here


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

         // Lets do the same with country now
        $dataProvider->sort->attributes['producto'] = [
            'asc' => ['productos.descripcion' => SORT_ASC],
            'desc' => ['productos.descripcion' => SORT_DESC],
        ];

         // Lets do the same with country now
         $dataProvider->sort->attributes['barcode'] = [
            'asc' => ['productos.codidoBarras' => SORT_ASC],
            'desc' => ['productos.codidoBarras' => SORT_DESC],
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
            'sucursalId' => $this->sucursalId,
            'productoId' => $this->productoId,
            'cantidad' => $this->cantidad,
        ])

        ->andFilterWhere(['like', 'productos.descripcion', $this->producto])
        ->andFilterWhere(['like', 'productos.codidoBarras', $this->barcode]);

        return $dataProvider;
    }
}
