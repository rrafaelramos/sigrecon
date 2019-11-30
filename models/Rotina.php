<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rotina".
 *
 * @property int $id
 * @property string $nome
 * @property int $repeticao
 * @property string $doc_entrega
 * @property string $doc_busca
 * @property string $data_entrega
 * @property string $data_aviso
 * @property string $informacao
 * @property string $msg_aviso
 */
class Rotina extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rotina';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'],'unique'],
            [['nome'], 'required'],
            [['repeticao'], 'required'],
            [['data_entrega', 'data_aviso'], 'safe'],
            [['nome', 'doc_entrega', 'doc_busca'], 'string', 'max' => 200],
            [['informacao', 'msg_aviso'], 'string', 'max' => 500],

            //Compara se a data da procuração é maior do que a de abertura, em caso positivo permite o cadastro!
            ['data_entrega', 'compare', 'compareAttribute' => 'data_aviso', 'operator' => '>=', 'message' => 'Data de Entrega deve ser posterior a Data de aviso!' ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Código',
            'nome' => 'Nome da Rotina',
            'repeticao' => 'Repetição/Período',
            'doc_entrega' => 'Doc. à ser Entregue',
            'doc_busca' => 'Doc. à Receber',
            'data_entrega' => 'Data de Entrega',
            'data_aviso' => 'Data de Aviso',
            'informacao' => 'Informações Adicionais',
            'msg_aviso' => 'Mensagem de Aviso',
        ];
    }
}
