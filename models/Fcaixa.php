<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fcaixa".
 *
 * @property int $id
 * @property string|null $data_inicio
 * @property string|null $data_fim
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
            [['data_inicio', 'data_fim'], 'safe'],
            [['entrada', 'saida', 'saldo', 'valor_abertura'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data_inicio' => 'Data Inicio',
            'data_fim' => 'Data Fim',
            'entrada' => 'Entrada',
            'saida' => 'Saida',
            'saldo' => 'Saldo',
        ];
    }
}
