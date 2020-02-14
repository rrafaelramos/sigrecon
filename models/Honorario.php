<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "honorario".
 *
 * @property int $id
 * @property float|null $valor
 * @property float|null $data_pagamento
 * @property float|null $referencia
 * @property int|null $usuario_fk
 * @property int|null $empresa_fk
 * @property string|null $observacao
 */
class Honorario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'honorario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['valor'], 'number'],
            [['empresa_fk','valor','referencia'],'required'],
            [['usuario_fk', 'empresa_fk'], 'integer'],
            [['observacao'], 'string'],
            [['data_caixa'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'valor' => 'Valor',
            'data_pagamento' => 'Data Pagamento',
            'data_caixa' => 'Data caixa',
            'referencia' => 'Data de referência',
            'usuario_fk' => 'Usuario',
            'empresa_fk' => 'Empresa',
            'observacao' => 'Observacao',
        ];
    }
}
