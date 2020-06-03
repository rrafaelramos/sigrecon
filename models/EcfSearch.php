<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ecf;

/**
 * EcfSearch represents the model behind the search form of `app\models\Ecf`.
 */
class EcfSearch extends Ecf
{
    public $buscar;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'associacao_id'], 'integer'],
            [['associacao_nome', 'data_limite', 'presidente', 'fone_presidente', 'feito', 'buscar'], 'safe'],
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
        $query = Ecf::find();

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
//            'id' => $this->id,
            'associacao_nome' => $this->buscar,
//            'data_limite' => $this->data_limite,
        ]);

        $query->orFilterWhere(['like', 'associacao_nome', $this->buscar])
            ->orFilterWhere(['like', 'presidente', $this->buscar])
            ->orFilterWhere(['like', 'fone_presidente', $this->buscar])
            ->orFilterWhere(['like', 'feito', $this->buscar]);

        return $dataProvider;
    }
}
