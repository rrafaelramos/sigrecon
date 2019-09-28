<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $nome
 * @property string $senha
 * @property string $telefone
 * @property string $email
 * @property int $tipo
 *
 * @property ClienteAvulso[] $clienteAvulsos
 * @property Compra[] $compras
 * @property Empresa[] $empresas
 */
class DBUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'senha', 'telefone', 'email'], 'required'],
            [['tipo'], 'integer'],
            [['nome'], 'string', 'max' => 120],
            [['senha'], 'string', 'max' => 50],
            [['telefone'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 100],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'senha' => 'Senha',
            'telefone' => 'Telefone',
            'email' => 'Email',
            'tipo' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClienteAvulsos()
    {
        return $this->hasMany(ClienteAvulso::className(), ['usuario_fk' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompras()
    {
        return $this->hasMany(Compra::className(), ['usuario_fk' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas()
    {
        return $this->hasMany(Empresa::className(), ['usuario_fk' => 'id']);
    }
}
