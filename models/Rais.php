<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rais".
 *
 * @property int $id
 * @property int|null $associacao_id
 * @property string|null $associacao_nome
 * @property string|null $data_limite
 * @property string|null $presidente
 * @property string|null $fone_presidente
 * @property string|null $feito
 */
class Rais extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rais';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['associacao_id'], 'integer'],
            [['data_limite'], 'safe'],
            [['associacao_nome', 'presidente'], 'string', 'max' => 200],
            [['fone_presidente'], 'string', 'max' => 20],
            [['feito'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'associacao_id' => 'Associacao ID',
            'associacao_nome' => 'Nome',
            'data_limite' => 'Data limite',
            'presidente' => 'Presidente',
            'fone_presidente' => 'Tel. do Presidente',
            'feito' => 'Feito',
        ];
    }
}
