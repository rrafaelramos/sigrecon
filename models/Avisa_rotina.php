<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "avisa_rotina".
 *
 * @property int $id
 * @property int|null $empresa_fk
 * @property int|null $rotina_fk
 * @property string|null $data_entrega
 * @property string|null $gera_auto
 * @property int|null $status_chegada
 * @property int|null $status_entrega
 * @property string|null $data_chegada
 * @property string|null $data_pronto
 * @property string|null $data_entregue
 * @property string|null $nome_rotina
 */
class Avisa_rotina extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'avisa_rotina';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa_fk', 'rotina_fk'], 'integer'],
            [['data_entrega', 'data_chegada', 'data_pronto', 'data_entregue'], 'safe'],
            [['status_chegada', 'status_entrega'],'safe'],
            [['nome_rotina'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'empresa_fk' => 'Empresa Fk',
            'rotina_fk' => 'Rotina Fk',
            'nome_rotina' => 'Nome da Rotina',
            'data_entrega' => 'Data Entrega',
            'status_chegada' => 'Status Chegada',
            'status_entrega' => 'Status Entrega',
            'data_chegada' => 'Data Chegada',
            'data_pronto' => 'Data Pronto',
            'data_entregue' => 'Data Entregue',
        ];
    }

    function empresa($model){
        $empresas = Empresa::find()->all();
        foreach ($empresas as $e){
            if($e->id == $model->empresa_fk){
                return "$e->razao_social";
            }
        }
    }

    function rotina($model){
        return $model->nome_rotina;
    }

    function dataLimite($d){
        $aux = explode('-',$d);
        $dia = $aux[2];
        $mes = $aux[1];
        $ano = $aux[0];
        return "$dia/$mes/$ano";
    }

    function dataEntregue($d){
        if($d){
            $aux = explode('-',$d);
            $dia = $aux[2];
            $mes = $aux[1];
            $ano = $aux[0];
            return "$dia/$mes/$ano";
        } else{
            return "Não foi entregue";
        }
    }

    function chegada($model){
        $rotinas = Rotina::find()->all();
        $doc = 0;
        if($model->nome_rotina == 'DEFIS'){
            return "Extrato do SN - Disponível no portal do Simples Nacional";
        }

        foreach ($rotinas as $r){
            if($r->id == $model->rotina_fk){
                $doc = $r->doc_busca;
            }
        }
        if(!$model->status_chegada){
            return "Aguardando: $doc";
        }else{
            return "$doc recebido(s)!";
        }
    }

    function entrega($model){
        if(!$model){
            return "Pendente!";
        }elseif ($model == 1){
            return "Pronto para entrega";
        }else{
            return "Entregue";
        }
    }

    public function geraRotina($empresa_fk,$rotina_fk,$data_entrega,$status_chegada,$status_entrega,$data_entregue){
        $tp = new \PhpOffice\PhpWord\TemplateProcessor(Yii::getAlias('@app') . '/documentos/avisarotina/avisarotina.docx');
        $dados = Avisa_rotina::find()->orderBy(['id'=>'SORT_DESC'])->all();
        var_dump($dados);
        die;

        $i = 0;
        $tp->cloneRow('empresa_fk', count($dados));

        ini_set('max_execution_time', 300); //300 seconds = 5 minute
        date_default_timezone_set('America/Sao_Paulo');

        $contabilidade = Contabilidade::find()->one();

        foreach($dados as $d){
            if($d->empresa_fk) {
                $tp->setValue('empresa_fk#' . ($i + 1), Avisa_rotina::empresa($d));
                $tp->setValue('rotina#' . ($i + 1), $d->nome_rotina);
                $tp->setValue('data_entrega#' . ($i + 1), Avisa_rotina::dataLimite($d->data_entrega));
                $tp->setValue('status_chegada#' . ($i + 1), Avisa_rotina::chegada($d));
                $tp->setValue('status_entrega#' . ($i + 1), Avisa_rotina::entrega($d->status_entrega));
                $tp->setValue('data_entregue#' . ($i + 1), Avisa_rotina::dataEntregue($d->data_entregue));
                $i++;
            }
        }

        $tp->setValue('contabilidade', "$contabilidade->nome");
        $tp->setValue('rua', "$contabilidade->rua");
        $tp->setValue('n', "$contabilidade->numero");
        $tp->setValue('bairro', "$contabilidade->bairro");
        $tp->setValue('cidade', "$contabilidade->cidade");
        $tp->setValue('data',date('d/m/Y'));

        $tp->saveAs(Yii::getAlias('@app') . '/documentos/avisarotina/avisarotina_temp.docx');
    }
}
