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
            [['cpf', 'nome'], 'required'],
            [['numero', 'rotina', 'usuario_fk'], 'integer'],
            [['datanascimento'], 'safe'],
            [['cpf'], 'string',],
            [['nome'], 'string', 'max' => 120],
            [['telefone'], 'string', 'max' => 20],
            [['rua', 'bairro', 'cidade'], 'string', 'max' => 200],
            [['cep'], 'string',],
            [['uf'], 'string', 'max' => 2],
            [['complemento'], 'string', 'max' => 255],
            [['cpf'], 'unique'],
            [['usuario_fk'], 'exist', 'skipOnError' => true, 'targetClass' => DBUser::className(), 'targetAttribute' => ['usuario_fk' => 'id']],
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
        return $this->hasOne(User::className(), ['id' => 'usuario_fk']);
    }
}
