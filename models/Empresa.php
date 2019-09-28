<?php

namespace app\models;

use Yii;

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
            [['cnpj', 'razao_social', 'rotina', 'cpf_socio'], 'required'],
            [['numero', 'rotina', 'usuario_fk'], 'integer'],
            [['data_abertura', 'data_procuracao', 'data_certificado', 'datanascimento_socio'], 'safe'],
            [['cnpj'], 'string', 'max' => 14],
            [['razao_social', 'nome_fantasia'], 'string', 'max' => 200],
            [['email'], 'string', 'max' => 100],
            [['telefone', 'celular', 'telefone_socio'], 'string', 'max' => 20],
            [['complemento'], 'string', 'max' => 50],
            [['rua', 'bairro', 'cidade', 'responsavel', 'nome_mae_socio'], 'string', 'max' => 120],
            [['cep'], 'string', 'max' => 8],
            [['uf'], 'string', 'max' => 2],
            [['cpf_socio', 'rg'], 'string', 'max' => 11],
            [['titulo'], 'string', 'max' => 12],
            [['cnpj'], 'unique'],
            [['usuario_fk'], 'exist', 'skipOnError' => true, 'targetClass' => DBUser::className(), 'targetAttribute' => ['usuario_fk' => 'id']],
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
            'nome_fantasia' => 'Nome Fantasia',
            'email' => 'Email',
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
            'data_procuracao' => 'Data de Vencimento da Procuração',
            'data_certificado' => 'Data Vencimento do Certificado',
            'rotina' => 'Rotina',
            'responsavel' => 'Nome',
            'cpf_socio' => 'CPF',
            'datanascimento_socio' => 'Data de nascimento',
            'rg' => 'RG',
            'titulo' => 'Título de Eleitor',
            'nome_mae_socio' => 'Nome da Mãe',
            'telefone_socio' => 'Telefone',
            'usuario_fk' => 'Usuário',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioFk()
    {
        return $this->hasOne(DBUser::className(), ['id' => 'usuario_fk']);
    }
}
