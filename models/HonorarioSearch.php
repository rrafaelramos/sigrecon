<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Honorario;

/**
 * HonorarioSearch represents the model behind the search form of `app\models\Honorario`.
 */
class HonorarioSearch extends Honorario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'usuario_fk', 'empresa_fk'], 'integer'],
            [['valor', 'data_pagamento', 'referencia'], 'number'],
            [['observacao'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Honorario::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
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
            'valor' => $this->valor,
            'data_pagamento' => $this->data_pagamento,
            'referencia' => $this->referencia,
            'usuario_fk' => $this->usuario_fk,
            'empresa_fk' => $this->empresa_fk,
        ]);

        $query->andFilterWhere(['like', 'observacao', $this->observacao]);

        return $dataProvider;
    }
}
