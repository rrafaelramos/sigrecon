<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alertaservico".
 *
 * @property int $id
 * @property int|null $cliente_fk
 * @property string|null $data_entrega
 * @property int|null $servico_fk
 * @property int|null $quantidade
 * @property string|null $info
 * @property int $status_pagamento
 * @property int|null $status_servico
 * @property int|null $usuario_fk
 */
class Alertaservico extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alertaservico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cliente_fk', 'servico_fk', 'quantidade', 'status_pagamento', 'status_servico', 'usuario_fk'], 'integer'],
            [['data_entrega'], 'safe'],
            [['info'], 'string'],
            [['status_pagamento'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cliente_fk' => 'Cliente Fk',
            'data_entrega' => 'Data Entrega',
            'servico_fk' => 'Servico Fk',
            'quantidade' => 'Quantidade',
            'info' => 'Info',
            'status_pagamento' => 'Status Pagamento',
            'status_servico' => 'Status Servico',
            'usuario_fk' => 'Usuario Fk',
        ];
    }
}
