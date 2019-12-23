<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Avisa_rotina;

/**
 * Avisa_rotinaSearch represents the model behind the search form of `app\models\Avisa_rotina`.
 */
class Avisa_rotinaSearch extends Avisa_rotina
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'empresa_fk', 'rotina_fk', 'status_chegada', 'status_entrega'], 'integer'],
            [['data_entrega', 'data_chegada', 'data_pronto', 'data_entregue'], 'safe'],
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
        $query = Avisa_rotina::find();

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
            'rotina_fk' => $this->rotina_fk,
            'data_entrega' => $this->data_entrega,
            'status_chegada' => $this->status_chegada,
            'status_entrega' => $this->status_entrega,
            'data_chegada' => $this->data_chegada,
            'data_pronto' => $this->data_pronto,
            'data_entregue' => $this->data_entregue,
        ]);

        return $dataProvider;
    }
}
