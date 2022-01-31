<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cajas;

/**
 * CajasSearch represents the model behind the search form of `app\models\Cajas`.
 */
class CajasSearch extends Cajas
{
    public $username;
    public $sucursal;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sucursalId', 'userId', 'isOpen', 'created_at', 'updated_at'], 'integer'],
            [['saldoInicial', 'saldoFinal'], 'number'],
            [['username', 'apertura', 'cierre'], 'safe'],
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
        $query = Cajas::find();

        // add conditions that should always apply here
        $query->joinWith(["user", "sucursal"]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


         // Lets do the same with user
        $dataProvider->sort->attributes['username'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        // Lets do the same with user
        $dataProvider->sort->attributes['sucursal'] = [
            'asc' => ['sucursal.nombre' => SORT_ASC],
            'desc' => ['sucursal.nombre' => SORT_DESC],
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
            'cajas.sucursalId' => $this->sucursalId,
            'userId' => $this->userId,
            'saldoInicial' => $this->saldoInicial,
            'saldoFinal' => $this->saldoFinal,
            'isOpen' => $this->isOpen,
            'created_at' => $this->created_at,
            'apertura' => $this->apertura,
            'cierre' => $this->cierre,
            'updated_at' => $this->updated_at,
        ])->andFilterWhere(['like', 'sucursal.nombre', $this->sucursal])
        ->andFilterWhere(['like', 'user.username', $this->username]);

        return $dataProvider;
    }
}
