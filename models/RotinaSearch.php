<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Rotina;

/**
 * RotinaSearch represents the model behind the search form of `app\models\Rotina`.
 */
class RotinaSearch extends Rotina
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'repeticao'], 'integer'],
            [['nome', 'doc_entrega', 'doc_busca', 'data_entrega', 'data_aviso', 'informacao', 'msg_aviso'], 'safe'],
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
        $query = Rotina::find();

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
            'repeticao' => $this->repeticao,
            'data_entrega' => $this->data_entrega,
            'data_aviso' => $this->data_aviso,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'doc_entrega', $this->doc_entrega])
            ->andFilterWhere(['like', 'doc_busca', $this->doc_busca])
            ->andFilterWhere(['like', 'informacao', $this->informacao])
            ->andFilterWhere(['like', 'msg_aviso', $this->msg_aviso]);

        return $dataProvider;
    }
}
