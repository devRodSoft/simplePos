<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Salidas;

/**
 * SalidasSearch represents the model behind the search form of `app\models\Salidas`.
 */
class SalidasSearch extends Salidas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cajaId', 'sucursalId', 'userId', 'retiroCantidad', 'created_at', 'updated_at'], 'integer'],
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
        $query = Salidas::find();

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
            'cajaId' => $this->cajaId,
            'sucursalId' => $this->sucursalId,
            'userId' => $this->userId,
            'retiroCantidad' => $this->retiroCantidad,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
