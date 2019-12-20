<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "abrircaixa".
 *
 * @property int $id
 * @property string|null $data
 * @property float|null $valor
 */
class Abrircaixa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'abrircaixa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data'], 'safe'],
            [['valor'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => 'Data',
            'valor' => 'Valor',
        ];
    }
}
