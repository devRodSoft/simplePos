<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Abonos;

/**
 * AbonosSearch represents the model behind the search form of `app\models\Abonos`.
 */
class AbonosSearch extends Abonos
{
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'clienteId', 'ventaId', 'userId', 'cajaId', 'abono', 'restante', 'created_at', 'updated_at'], 'integer'],
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
        $query = Abonos::find();

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
            'clienteId' => $this->clienteId,
            'ventaId' => $this->ventaId,
            'userId' => $this->userId,
            'cajaId' => $this->cajaId,
            'abono' => $this->abono,
            'restante' => $this->restante,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
