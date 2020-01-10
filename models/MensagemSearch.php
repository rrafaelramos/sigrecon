<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mensagem;

/**
 * MensagemSearch represents the model behind the search form of `app\models\Mensagem`.
 */
class MensagemSearch extends Mensagem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'emissor', 'receptor', 'lido'], 'integer'],
            [['data_envio', 'titulo', 'conteudo'], 'safe'],
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
        $query = Mensagem::find();

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
            'emissor' => $this->emissor,
            'receptor' => $this->receptor,
            'data_envio' => $this->data_envio,
            'lido' => $this->lido,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'conteudo', $this->conteudo]);

        return $dataProvider;
    }
}
