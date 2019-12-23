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
 * @property int|null $status_chegada
 * @property int|null $status_entrega
 * @property string|null $data_chegada
 * @property string|null $data_pronto
 * @property string|null $data_entregue
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
            [['empresa_fk', 'rotina_fk', 'status_chegada', 'status_entrega'], 'integer'],
            [['data_entrega', 'data_chegada', 'data_pronto', 'data_entregue'], 'safe'],
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
            'data_entrega' => 'Data Entrega',
            'status_chegada' => 'Status Chegada',
            'status_entrega' => 'Status Entrega',
            'data_chegada' => 'Data Chegada',
            'data_pronto' => 'Data Pronto',
            'data_entregue' => 'Data Entregue',
        ];
    }
}
