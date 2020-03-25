<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contabilidade".
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $responsavel
 * @property string|null $cnpj
 * @property string|null $crc
 * @property string|null $telefone
 * @property int|null $numero
 * @property string|null $rua
 * @property string|null $bairro
 * @property string|null $cidade
 */
class Contabilidade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contabilidade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['numero'], 'integer'],
            [['nome', 'responsavel'], 'string', 'max' => 300],
            [['cnpj', 'crc'], 'string', 'max' => 25],
            [['telefone'], 'string', 'max' => 20],
            [['rua', 'bairro', 'cidade'], 'string', 'max' => 200],
            [['cnpj'], 'unique'],
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
            'responsavel' => 'Responsavel',
            'cnpj' => 'Cnpj',
            'crc' => 'Crc',
            'telefone' => 'Telefone',
            'numero' => 'Numero',
            'rua' => 'Rua',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
        ];
    }
}
