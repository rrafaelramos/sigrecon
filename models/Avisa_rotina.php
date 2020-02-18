<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "avisa_rotina".
 *
 * @property int $id
 * @property int|null $empresa_fk
 * @property int|null $rotina_fk
 * @property string|null $data_entrega
 * @property string|null $gera_auto
 * @property int|null $status_chegada
 * @property int|null $status_entrega
 * @property string|null $data_chegada
 * @property string|null $data_pronto
 * @property string|null $data_entregue
 * @property string|null $nome_rotina
 */
class Avisa_rotina extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'avisa_rotina';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa_fk', 'rotina_fk'], 'integer'],
            [['data_entrega', 'data_chegada', 'data_pronto', 'data_entregue'], 'safe'],
            [['status_chegada', 'status_entrega'],'safe'],
            [['nome_rotina'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'empresa_fk' => 'Empresa Fk',
            'rotina_fk' => 'Rotina Fk',
            'nome_rotina' => 'Nome da Rotina',
            'data_entrega' => 'Data Entrega',
            'status_chegada' => 'Status Chegada',
            'status_entrega' => 'Status Entrega',
            'data_chegada' => 'Data Chegada',
            'data_pronto' => 'Data Pronto',
            'data_entregue' => 'Data Entregue',
        ];
    }
}
