<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Alertaservicopj;

/**
 * AlertaservicopjSearch represents the model behind the search form of `app\models\Alertaservicopj`.
 */
class AlertaservicopjSearch extends Alertaservicopj
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'empresa_fk', 'servico_fk', 'quantidade', 'status_pagamento', 'status_servico', 'usuario_fk'], 'integer'],
            [['data_entrega', 'data_pago', 'info'], 'safe'],
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
        $query = Alertaservicopj::find();

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
            'empresa_fk' => $this->empresa_fk,
            'data_entrega' => $this->data_entrega,
            'data_pago' => $this->data_pago,
            'servico_fk' => $this->servico_fk,
            'quantidade' => $this->quantidade,
            'status_pagamento' => $this->status_pagamento,
            'status_servico' => $this->status_servico,
            'usuario_fk' => $this->usuario_fk,
        ]);

        $query->andFilterWhere(['like', 'info', $this->info]);

        return $dataProvider;
    }
}
