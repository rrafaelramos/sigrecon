<?php

namespace app\models;

use Yii;
use yiibr\brvalidator\CnpjValidator;
use yiibr\brvalidator\CpfValidator;

/**
 * This is the model class for table "associacao".
 *
 * @property int $id
 * @property string $cnpj
 * @property string $razao_social
 * @property string|null $email
 * @property string|null $telefone
 * @property string|null $rua
 * @property string|null $numero
 * @property string|null $bairro
 * @property string|null $cidade
 * @property string|null $complemento
 * @property string|null $cep
 * @property string|null $uf
 * @property string|null $data_procuracao
 * @property string|null $data_certificado
 * @property string|null $responsavel
 * @property string $cpf_socio
 * @property string|null $datanascimento_socio
 * @property string|null $rg
 * @property string|null $titulo
 * @property string|null $nome_mae_socio
 * @property string|null $telefone_socio
 */
class Associacao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'associacao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cnpj', 'razao_social', 'cpf_socio','responsavel','rg','telefone_socio'], 'required'],
            [['data_procuracao', 'data_certificado', 'datanascimento_socio'], 'safe'],
            [['cnpj'], 'string'],
            [['razao_social'], 'string', 'max' => 200],
            [['email'], 'email'],
            [['telefone', 'telefone_socio'], 'string', 'max' => 20],
            [['rua', 'bairro', 'cidade', 'responsavel', 'nome_mae_socio'], 'string', 'max' => 120],
            [['numero'], 'integer'],
            [['complemento'], 'string', 'max' => 50],
            [['cep'], 'string'],
            [['uf'], 'string', 'max' => 2],
            [['cpf_socio'], 'string'],
            [['rg'], 'string', 'max' => 25],
            [['titulo'], 'string', 'max' => 12],
            [['cnpj'], 'unique'],
            [['cnpj'], CnpjValidator::className()],
            [['cpf_socio'], CpfValidator::className()]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cnpj' => 'CNPJ',
            'razao_social' => 'Razão Social',
            'email' => 'e-Mail',
            'telefone' => 'Telefone Fixo',
            'rua' => 'Rua',
            'numero' => 'Número',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'complemento' => 'Complemento',
            'cep' => 'CEP',
            'uf' => 'UF',
            'data_procuracao' => 'Procuração válida até:',
            'data_certificado' => 'Certificado válido até:',
            'responsavel' => 'Presidente',
            'cpf_socio' => 'CPF',
            'datanascimento_socio' => 'Data de Nascimento',
            'rg' => 'RG',
            'titulo' => 'Título de eleitor',
            'nome_mae_socio' => 'Nome da Mãe',
            'telefone_socio' => 'Tel. Presidente',
        ];
    }

    function procurac($model){
        if(strtotime($model->data_procuracao) > strtotime(date("Y-m-d"))){
            //retorna a data do model, e transforma em um array
            $dataprocuracao = explode('-',$model->data_procuracao);
            $dia = $dataprocuracao[2];
            $mes = $dataprocuracao[1];
            $ano = $dataprocuracao[0];
            return "$dia/$mes/$ano";
        }elseif(strtotime($model->data_procuracao) == strtotime(date("Y-m-d"))){
            return 'Hoje!';
        }else{
            return 'Expirou!';
        }
    }

    function certifica($model){
        if(strtotime($model->data_certificado) > strtotime(date("Y-m-d"))){
            date_default_timezone_set('America/Sao_Paulo');
            $datacertificado = explode('-',$model->data_certificado);
            $diac = $datacertificado[2];
            $mesc = $datacertificado[1];
            $anoc = $datacertificado[0];
            return "$diac/$mesc/$anoc";
        }elseif(strtotime($model->data_certificado) == strtotime(date("Y-m-d"))){
            return 'Hoje!';
        }else{
            return 'Expirou';
        }
    }

    function telefonesocio($model){
        return preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->telefone_socio);
    }

    public function geraDataVenc($razao_social, $data_procuracao, $data_certificado, $celular, $responsavel){
//        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        $tp = new \PhpOffice\PhpWord\TemplateProcessor(Yii::getAlias('@app') . '/documentos/data_venc/data_venc.docx');
        $dados = Associacao::find()->orderBy('razao_social')->all();

        $i = 0;
        $total = 0;

        $tp->setValue('tipo', 'Associações');

        $tp->cloneRow('razao_social', count($dados));

        ini_set('max_execution_time', 300); //300 seconds = 5 minute
        date_default_timezone_set('America/Sao_Paulo');

        $contabilidade = Contabilidade::find()->one();

        foreach($dados as $d){
            if($d->data_certificado || $d->data_procuracao) {
                $tp->setValue('razao_social#' . ($i + 1), $d->razao_social);
                $tp->setValue('data_procuracao#' . ($i + 1), Associacao::procurac($d));
                $tp->setValue('data_certificado#' . ($i + 1), Associacao::certifica($d));
                $tp->setValue('celular#' . ($i + 1), Associacao::telefonesocio($d));
                $tp->setValue('responsavel#' . ($i + 1), $d['responsavel']);
                $i++;
            }
        }

        $tp->setValue('contabilidade', "$contabilidade->nome");
        $tp->setValue('rua', "$contabilidade->rua");
        $tp->setValue('n', "$contabilidade->numero");
        $tp->setValue('bairro', "$contabilidade->bairro");
        $tp->setValue('cidade', "$contabilidade->cidade");
        $tp->setValue('data',date('d/m/Y'));

        $tp->saveAs(Yii::getAlias('@app') . '/documentos/data_venc/data_venc_temp.docx');
    }

    // retorna o número de certificados que irão expirar no dia!
    function certificado(){
        $data = date('Y-m-d');
        $ass = Associacao::find()->all();
        $arrayass = array();
        $cont = 0;
        foreach ($ass as $emp){
            if($emp->data_certificado == $data){
                $cont++;
            }
        }
        if($cont>1){
            return "   $cont Certificados de Associação!";
        }elseif ($cont==1){
            return "   $cont certificado de Associação";
        }else{
            return 0;
        }
    }

//retorna o número de procuracao que irão expirar no dia!
    function procuracao(){
        $data = date('Y-m-d');
        $ass = Associacao::find()->all();$cont = 0;
        foreach ($ass as $emp){
            if($emp->data_procuracao == $data){
                $cont++;
            }
        }
        if($cont>1){
            return "   $cont procuracao de Associações!";
        }elseif ($cont==1){
            return "   $cont procuração Associação!";
        }else{
            return 0;
        }
    }
}
