<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ecf".
 *
 * @property int $id
 * @property int|null $associacao_id
 * @property string|null $associacao_nome
 * @property string|null $data_limite
 * @property string|null $presidente
 * @property string|null $fone_presidente
 * @property string|null $feito
 */
class Ecf extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ecf';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['associacao_id'], 'integer'],
            [['data_limite'], 'safe'],
            [['associacao_nome', 'presidente'], 'string', 'max' => 200],
            [['fone_presidente'], 'string', 'max' => 20],
            [['feito'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'associacao_id' => 'Associacao ID',
            'associacao_nome' => 'Associacao Nome',
            'data_limite' => 'Data Limite',
            'presidente' => 'Presidente',
            'fone_presidente' => 'Fone Presidente',
            'feito' => 'Feito',
        ];
    }

    public function geraEntrega($data){
        date_default_timezone_set('America/Sao_Paulo');
        $data_tabela = Ecf::find()->max('data_limite');

        $data_explode = explode('-',$data_tabela);
        $ano = $data_explode[0];

        $ecfs = Ecf::find()->all();
        $associacoes = Associacao::find()->all();

        if($data > $ano){
            foreach ($associacoes as $associacao){
                $model = new Ecf();
                $model->associacao_id = $associacao->id;
                $model->associacao_nome = $associacao->razao_social;
                $model->data_limite = "$data-07-31";
                $model->presidente = $associacao->responsavel;
                $model->fone_presidente = $associacao->telefone_socio;
                $model->feito = 'Não';
                $model->save();
            }
            return 1;
        }
    }

}
