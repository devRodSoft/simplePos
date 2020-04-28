<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ventas;

/**
 * VentasSearch represents the model behind the search form of `app\models\Ventas`.
 */
class VentasSearch extends Ventas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {

            return [
                [['id', 'updated_at'], 'integer'],
                [['total', 'descuento'], 'number'],
                [['descripcion'], 'string'],
                [['created_at'], 'safe'],
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
       $query = Ventas::find();
       
      // $query->andFilterWhere(['between', 'created_at', date('Y.m.d 00:00:00'), date('Y.m.d 22:00:00')]);

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
            'total' => $this->total,
            'descuento' => $this->descuento,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ])->andFilterWhere(['like', 'descripcion', $this->descripcion]);


        return $dataProvider;
    }
}
