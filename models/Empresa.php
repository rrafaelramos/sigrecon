<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yiibr\brvalidator\CpfValidator;
use yiibr\brvalidator\CnpjValidator;
use yiibr\brvalidator\CeiValidator;
//use app\components\validators\DataValida;

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
            [['cnpj', 'razao_social', 'rotina', 'cpf_socio', 'responsavel', 'telefone_socio'], 'required'],
            [['rotina', 'usuario_fk'], 'integer'],
            [['data_abertura', 'data_procuracao', 'data_certificado', 'datanascimento_socio'], 'safe'],
            [['data_abertura'], 'validarData'],

            //Compara se a data da procuração é maior do que a de abertura, em caso positivo permite o cadastro!
            ['data_procuracao', 'compare', 'compareAttribute' => 'data_abertura', 'operator' => '>=', 'message' => 'Data Inválida!' ],
            ['data_certificado', 'compare', 'compareAttribute' => 'data_abertura', 'operator' => '>=', 'message' => 'Data Inválida!' ],
            [['datanascimento_socio'], 'validarIdade' ],


            [['numero','cnpj'], 'string',],
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
            [['usuario_fk'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_fk' => 'id']],
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

    //Validar dta valida a idade do sócio;
    public function validarIdade($attribute, $params, $validator)
    {
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

        if ($idadeano<18) {
            $this->addError($attribute, 'O Sócio não pode ser Menor de Idade');
        }elseif($idadeano==18 && $mes<$mesform){
            $this->addError($attribute, 'O Sócio não pode ser Menor de Idade'.$mesform);
        }elseif ($idadeano==18 && $idademes==0 && $dia<$diaform){
            $this->addError($attribute, 'O Sócio não pode ser Menor de Idade'.$diaform);
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
            'numero' => 'N°',
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
    public function getUsuarioFk()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_fk']);
    }
}
