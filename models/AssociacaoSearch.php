<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Associacao;

/**
 * AssociacaoSearch represents the model behind the search form of `app\models\Associacao`.
 */
class AssociacaoSearch extends Associacao
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['cnpj', 'razao_social', 'email', 'telefone', 'rua', 'numero', 'bairro', 'cidade', 'complemento', 'cep', 'uf', 'data_procuracao', 'data_certificado', 'responsavel', 'cpf_socio', 'datanascimento_socio', 'rg', 'titulo', 'nome_mae_socio', 'telefone_socio'], 'safe'],
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
        $query = Associacao::find();

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
            'data_procuracao' => $this->data_procuracao,
            'data_certificado' => $this->data_certificado,
            'datanascimento_socio' => $this->datanascimento_socio,
        ]);

        $query->andFilterWhere(['like', 'cnpj', $this->cnpj])
            ->andFilterWhere(['like', 'razao_social', $this->razao_social])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'telefone', $this->telefone])
            ->andFilterWhere(['like', 'rua', $this->rua])
            ->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['like', 'bairro', $this->bairro])
            ->andFilterWhere(['like', 'cidade', $this->cidade])
            ->andFilterWhere(['like', 'complemento', $this->complemento])
            ->andFilterWhere(['like', 'cep', $this->cep])
            ->andFilterWhere(['like', 'uf', $this->uf])
            ->andFilterWhere(['like', 'responsavel', $this->responsavel])
            ->andFilterWhere(['like', 'cpf_socio', $this->cpf_socio])
            ->andFilterWhere(['like', 'rg', $this->rg])
            ->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'nome_mae_socio', $this->nome_mae_socio])
            ->andFilterWhere(['like', 'telefone_socio', $this->telefone_socio]);

        return $dataProvider;
    }
}