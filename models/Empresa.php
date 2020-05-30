<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\debug\models\timeline\Search;
use yiibr\brvalidator\CpfValidator;
use yiibr\brvalidator\CnpjValidator;
use yiibr\brvalidator\CeiValidator;
use PhpOffice\PhpWord\PhpWord;

/**
 * This is the model class for table "empresa".
 *
 * @property int $id
 * @property string $cnpj
 * @property string $razao_social
 * @property string $nome_fantasia
 * @property string $email
 * @property string $telefone
 * @property string $celular
 * @property int $numero
 * @property string $complemento
 * @property string $rua
 * @property string $bairro
 * @property string $cidade
 * @property string $cep
 * @property string $uf
 * @property string $data_abertura
 * @property string $data_procuracao
 * @property string $data_certificado
 * @property int $rotina
 * @property string $responsavel
 * @property string $cpf_socio
 * @property string $datanascimento_socio
 * @property string $rg
 * @property string $titulo
 * @property string $nome_mae_socio
 * @property string $telefone_socio
 * @property int $usuario_fk
 *
 * @property User $usuarioFk
 * @property Rotina_empresa[] $rotinaEmpresas
 * @property Rotina[] $rotinas
 */
class Empresa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'empresa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {

        return [
            [['cnpj', 'razao_social', 'rotina', 'cpf_socio', 'responsavel'], 'required'],
            [['telefone_socio'],'string'],
            [['rotina', 'usuario_fk'], 'integer'],
            [['data_abertura', 'data_procuracao', 'data_certificado', 'datanascimento_socio'], 'safe'],
            [['data_abertura'], 'validarData'],

            //Compara se a data da procuração é maior do que a de abertura, em caso positivo permite o cadastro!
            ['data_procuracao', 'compare', 'compareAttribute' => 'data_abertura', 'operator' => '>=', 'message' => 'Data Inválida!' ],
            ['data_certificado', 'compare', 'compareAttribute' => 'data_abertura', 'operator' => '>=', 'message' => 'Data Inválida!' ],
            [['datanascimento_socio'], 'validarIdade' ],

            [['numero'],'integer'],
            [['cnpj'], 'string',],
            [['razao_social', 'nome_fantasia'], 'string', 'max' => 200],
            [['email'], 'email'],
            [['telefone', 'celular'], 'string', 'max' => 20],
            [['complemento'], 'string', 'max' => 50],
            [['rua', 'bairro', 'cidade', 'responsavel', 'nome_mae_socio'], 'string', 'max' => 120],
            [['cep'], 'string',],
            [['uf'], 'string',],
            [['cpf_socio', 'rg'], 'string',],
            [['titulo'], 'string', 'max' => 12],
            [['cnpj'], 'unique'],
            [['usuario_fk'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_fk' => 'id']],
            [['cnpj'], CnpjValidator::className()],
            [['cpf_socio'], CpfValidator::className()]
        ];

    }
    public function validarData($attribute, $params, $validator)
    {
        $data = date("Y/m/d");

        if (strtotime($this->$attribute) > strtotime($data)) {
            $formatar = date("d/m/Y");
            $this->addError($attribute, 'A data deve ser Inferior ou igual a: '.$formatar);
        }
    }

    //Valida a idade do sócio;
    public function validarIdade($attribute, $params, $validator)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $data = date("Y/m/d");
        $guardadata = explode('/',$data);
        $ano = $guardadata[0];
        $mes = $guardadata[1];
        $dia = $guardadata[2];
        $ano = intval($ano);
        $mes = intval($mes);
        $dia = intval($dia);

        $dataform = explode('-',$this->datanascimento_socio);
        $anoform = $dataform[0];
        $mesform = $dataform[1];
        $diaform = $dataform[2];
        $anoform = intval($anoform);
        $mesform = intval($mesform);
        $diaform = intval($diaform);

        $idadeano = ($ano-$anoform);
        $idademes = ($mes-$mesform);
        $idadedia = ($dia-$diaform);

        if(strtotime($this->datanascimento_socio) >= strtotime($data)){
            return $this->addError($attribute, 'Data inválida!');
        }

        if ($idadeano<18) {
            $this->addError($attribute, 'O Sócio não pode ser Menor de Idade!');
        }elseif($idadeano==18 && $mes<$mesform){
            $this->addError($attribute, 'O Sócio não pode ser Menor de Idade!');
        }elseif ($idadeano==18 && $idademes==0 && $dia<$diaform){
            $this->addError($attribute, 'O Sócio não pode ser Menor de Idade!');
        }
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
            'nome_fantasia' => 'Nome Fantasia',
            'email' => 'E-mail',
            'telefone' => 'Telefone',
            'celular' => 'Celular',
            'numero' => 'Número',
            'complemento' => 'Complemento',
            'rua' => 'Logradouro',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'cep' => 'CEP',
            'uf' => 'UF',
            'data_abertura' => 'Data de Constituição',
            'data_procuracao' => 'Procuração válida até:',
            'data_certificado' => 'Certificado válido até:',
            'rotina' => 'Rotina',
            'responsavel' => 'Nome do Responsável',
            'cpf_socio' => 'CPF',
            'datanascimento_socio' => 'Data de nascimento',
            'rg' => 'RG',
            'titulo' => 'Título de Eleitor',
            'nome_mae_socio' => 'Nome da Mãe',
            'telefone_socio' => 'Celular do Sócio',
            'usuario_fk' => 'Usuário',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRotinaEmpresas(){
        return $this->hasMany(Rotina_empresa::className(),['empresa_fk' => 'id']);
    }

    public function getRotinas(){
        return $this->hasMany(Rotina::className(), ['id' => 'rotina'])
            ->viaTable(Rotina_empresa::tableName(), ['rotina_fk' => 'id']);
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
        $dados = Empresa::find()->orderBy('razao_social')->all();

        $i = 0;
        $total = 0;

        $tp->setValue('tipo', 'Empresas');

        $tp->cloneRow('razao_social', count($dados));

        ini_set('max_execution_time', 300); //300 seconds = 5 minute
        date_default_timezone_set('America/Sao_Paulo');

        $contabilidade = Contabilidade::find()->one();

        foreach($dados as $d){
            if($d->data_certificado || $d->data_procuracao) {
                $tp->setValue('razao_social#' . ($i + 1), $d->razao_social);
                $tp->setValue('data_procuracao#' . ($i + 1), Empresa::procurac($d));
                $tp->setValue('data_certificado#' . ($i + 1), Empresa::certifica($d));
                $tp->setValue('celular#' . ($i + 1), Empresa::telefonesocio($d));
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
}
