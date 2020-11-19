<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rais".
 *
 * @property int $id
 * @property int|null $associacao_id
 * @property string|null $associacao_nome
 * @property string|null $data_limite
 * @property string|null $presidente
 * @property string|null $fone_presidente
 * @property string|null $feito
 */
class Rais extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rais';
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
            'associacao_nome' => 'Nome',
            'data_limite' => 'Data limite',
            'presidente' => 'Presidente',
            'fone_presidente' => 'Tel. do Presidente',
            'feito' => 'Feito',
        ];
    }

    public function geraEntrega($data){
        date_default_timezone_set('America/Sao_Paulo');
        $data_tabela = Rais::find()->max('data_limite');

        $data_explode = explode('-',$data_tabela);
        $ano = $data_explode[0];

        $rais = Rais::find()->all();
        $associacoes = Associacao::find()->all();

        if($data > $ano){
            foreach ($associacoes as $associacao){
                $model = new Rais();
                $model->associacao_id = $associacao->id;
                $model->associacao_nome = $associacao->razao_social;
                $model->data_limite = "$data-09-08";
                $model->presidente = $associacao->responsavel;
                $model->fone_presidente = $associacao->telefone_socio;
                $model->feito = 'Não';
                $model->save();
            }

            $cont = 0;
            $lembretes = Lembrete::find()->all();
            foreach ($lembretes as $lembrete){
                if($lembrete->titulo == "Prazo Final: RAIS $data"){
                    $cont++;
                }
            }
            if(!$cont) {
                $lembrete = new Lembrete();
                $lembrete->titulo = "Prazo Final: RAIS $data";
                $lembrete->alerta_geral = 1;
                $lembrete->data = "$data-09-08";
                $lembrete->save();
            }
            return 1;
        }
    }
}
