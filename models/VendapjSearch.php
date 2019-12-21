<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Vendapj;

/**
 * VendapjSearch represents the model behind the search form of `app\models\Vendapj`.
 */
class VendapjSearch extends Vendapj
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'empresa_fk', 'usuario_fk', 'servico_fk', 'quantidade'], 'integer'],
            [['data'], 'safe'],
            [['total'], 'number'],
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
        $query = Vendapj::find();

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
            'data' => $this->data,
            'empresa_fk' => $this->empresa_fk,
            'usuario_fk' => $this->usuario_fk,
            'servico_fk' => $this->servico_fk,
            'quantidade' => $this->quantidade,
            'total' => $this->total,
        ]);

        return $dataProvider;
    }
}
