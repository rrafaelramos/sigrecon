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
            [['repeticao'], 'required'],
            [['repeticao'], 'integer'],
            [['data_entrega', 'data_aviso'], 'safe'],
            [['nome', 'doc_entrega', 'doc_busca'], 'string', 'max' => 200],
            [['informacao', 'msg_aviso'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Código',
            'nome' => 'Nome',
            'repeticao' => 'Repetição',
            'doc_entrega' => 'Doc. à ser Entregue',
            'doc_busca' => 'Doc. à Receber',
            'data_entrega' => 'Data de Entrega',
            'data_aviso' => 'Data de Aviso',
            'informacao' => 'Informações Adicionais',
            'msg_aviso' => 'Mensagem de Aviso',
        ];
    }
}
