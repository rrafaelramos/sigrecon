<?php

namespace app\models;
use yiibr\brvalidator\CpfValidator;
use yiibr\brvalidator\CnpjValidator;
use yiibr\brvalidator\CeiValidator;

use Yii;

/**
 * This is the model class for table "clienteavulso".
 *
 * @property int $id
 * @property string $cpf
 * @property string $nome
 * @property string $telefone
 * @property int $numero
 * @property string $rua
 * @property string $bairro
 * @property string $cidade
 * @property string $cep
 * @property string $uf
 * @property int $rotina
 * @property string $datanascimento
 * @property int $usuario_fk
 * @property string $complemento
 *
 * @property User $usuarioFk
 */
class Clienteavulso extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clienteavulso';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cpf', 'nome','telefone'], 'required'],
            [['numero', 'rotina', 'usuario_fk'], 'integer'],
            [['datanascimento'], 'validarIdade'],
            [['cpf'], 'string',],
            [['nome'], 'string', 'max' => 120],
            [['telefone'], 'string', 'max' => 20],
            [['rua', 'bairro', 'cidade'], 'string', 'max' => 200],
            [['cep'], 'string',],
            [['uf'], 'string'],
            [['complemento'], 'string', 'max' => 255],
            [['cpf'], 'unique'],
            [['usuario_fk'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_fk' => 'id']],
            [['cpf'], CpfValidator::className()],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cpf' => 'CPF',
            'nome' => 'Nome',
            'telefone' => 'Telefone',
            'numero' => 'Número',
            'rua' => 'Rua',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'cep' => 'CEP',
            'uf' => 'Estado',
            'rotina' => 'Rotina',
            'datanascimento' => 'Data de nascimento',
            'usuario_fk' => 'Usuario Fk',
            'complemento' => 'Complemento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioFk()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_fk']);
    }

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

        $dataform = explode('-',$this->datanascimento);
        $anoform = $dataform[0];
        $mesform = $dataform[1];
        $diaform = $dataform[2];
        $anoform = intval($anoform);
        $mesform = intval($mesform);
        $diaform = intval($diaform);

        $idadeano = ($ano-$anoform);
        $idademes = ($mes-$mesform);
        $idadedia = ($dia-$diaform);

        if(strtotime($this->datanascimento) >= strtotime($data)){
            return $this->addError($attribute, 'Data inválida!');
        }

        if ($idadeano<18) {
            $this->addError($attribute, 'Não pode ser Menor de Idade!');
        }elseif($idadeano==18 && $mes<$mesform){
            $this->addError($attribute, 'Não pode ser Menor de Idade!');
        }elseif ($idadeano==18 && $idademes==0 && $dia<$diaform){
            $this->addError($attribute, 'Não pode ser Menor de Idade!');
        }
    }
}
