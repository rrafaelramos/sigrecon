<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Empresa;

/**
 * EmpresaSearch represents the model behind the search form of `app\models\Empresa`.
 */
class EmpresaSearch extends Empresa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'numero', 'rotina', 'usuario_fk'], 'integer'],
            [['cnpj', 'razao_social', 'nome_fantasia', 'email', 'telefone', 'celular', 'complemento', 'rua', 'bairro', 'cidade', 'cep', 'uf', 'data_abertura', 'data_procuracao', 'data_certificado', 'responsavel', 'cpf_socio', 'datanascimento_socio', 'rg', 'titulo', 'nome_mae_socio', 'telefone_socio'], 'safe'],
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
        $query = Empresa::find();

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
            'numero' => $this->numero,
            'data_abertura' => $this->data_abertura,
            'data_procuracao' => $this->data_procuracao,
            'data_certificado' => $this->data_certificado,
            'rotina' => $this->rotina,
            'datanascimento_socio' => $this->datanascimento_socio,
            'usuario_fk' => $this->usuario_fk,
        ]);

        $query->andFilterWhere(['like', 'cnpj', $this->cnpj])
            ->andFilterWhere(['like', 'razao_social', $this->razao_social])
            ->andFilterWhere(['like', 'nome_fantasia', $this->nome_fantasia])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'telefone', $this->telefone])
            ->andFilterWhere(['like', 'celular', $this->celular])
            ->andFilterWhere(['like', 'complemento', $this->complemento])
            ->andFilterWhere(['like', 'rua', $this->rua])
            ->andFilterWhere(['like', 'bairro', $this->bairro])
            ->andFilterWhere(['like', 'cidade', $this->cidade])
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
