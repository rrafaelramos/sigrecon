<?php

namespace app\models;

use Yii;
use PhpOffice\PhpWord\PhpWord;

/**
 * This is the model class for table "itr".
 *
 * @property int $id
 * @property int|null $cliente_fk
 * @property string|null $data_entrega
 * @property string|null $telefone
 */
class Itr extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'itr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cliente_fk'], 'integer'],
            [['data_entrega'], 'safe'],
            [['telefone'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cliente_fk' => 'Cliente Fk',
            'data_entrega' => 'Data Entrega',
            'telefone' => 'Telefone',
        ];
    }

    public function geraEntrega($data){
        date_default_timezone_set('America/Sao_Paulo');
        $data_tabela = Itr::find()->max('data_entrega');

        $data_explode = explode('-',$data_tabela);
        $ano = $data_explode[0];

        $itrs = Itr::find()->all();
        $clientes = Clienteavulso::find()->all();

        if($data > $ano){
            foreach ($itrs as $itr){
                $itr->delete($itr->id);
            }
            foreach ($clientes as $cliente){
                if($cliente->rotina == 3){
                    $model = new Itr();
                    $model->cliente_fk = $cliente->id;
                    $data_entrega = "$data-09-30";
                    $model->data_entrega = $data_entrega;
                    $model->telefone = $cliente->telefone;
                    $model->save();
                }
            }
            return 1;
        }
    }

    function cliente($d){
        $clientes = Clienteavulso::find()->all();
        foreach ($clientes as $cliente){
            if($d->cliente_fk == $cliente->id){
                return "$cliente->nome";
            }
        }
    }

    function data($data){
            $data = explode('-',$data);
            $dia = $data[2];
            $mes = $data[1];
            $ano = $data[0];
            return "$dia/$mes/$ano";
    }

    function telefone($d){
        return preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $d);
    }


    public function geraItr($cliente_fk, $telefone, $data_entrega){
        $tp = new \PhpOffice\PhpWord\TemplateProcessor(Yii::getAlias('@app') . '/documentos/itr/itr.docx');
        $dados = Itr::find()->orderBy('cliente_fk')->all();

        $i = 0;
        $tp->cloneRow('cliente_fk', count($dados));

        ini_set('max_execution_time', 300); //300 seconds = 5 minute
        date_default_timezone_set('America/Sao_Paulo');

        $contabilidade = Contabilidade::find()->one();

        foreach($dados as $d){
            if($d->cliente_fk) {
                $tp->setValue('cliente_fk#' . ($i + 1), Itr::cliente($d));
                $tp->setValue('telefone#' . ($i + 1), Itr::telefone($d->telefone));
                $tp->setValue('data_entrega#' . ($i + 1), Itr::data($d->data_entrega));
                $i++;
            }
        }

        $tp->setValue('contabilidade', "$contabilidade->nome");
        $tp->setValue('rua', "$contabilidade->rua");
        $tp->setValue('n', "$contabilidade->numero");
        $tp->setValue('bairro', "$contabilidade->bairro");
        $tp->setValue('cidade', "$contabilidade->cidade");
        $tp->setValue('data',date('d/m/Y'));

        $tp->saveAs(Yii::getAlias('@app') . '/documentos/itr/itr_temp.docx');
    }
}