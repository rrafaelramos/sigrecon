<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fcaixa".
 *
 * @property int $id
 * @property string|null $data_fechamento
 * @property float|null $entrada
 * @property float|null $saida
 * @property float|null $saldo
 */
class Fcaixa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fcaixa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data_fechamento'], 'safe'],
            [['entrada', 'saida', 'saldo'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data_fechamento' => 'Data Fechamento',
            'entrada' => 'Entrada',
            'saida' => 'Saida',
            'saldo' => 'Saldo',
        ];
    }
}
