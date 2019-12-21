<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alertaservicopj".
 *
 * @property int $id
 * @property int|null $empresa_fk
 * @property string|null $data_entrega
 * @property string|null $data_pago
 * @property int|null $servico_fk
 * @property int|null $quantidade
 * @property string|null $info
 * @property int $status_pagamento
 * @property int|null $status_servico
 * @property int|null $usuario_fk
 */
class Alertaservicopj extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alertaservicopj';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa_fk', 'servico_fk', 'quantidade', 'status_pagamento', 'status_servico', 'usuario_fk'], 'integer'],
            [['data_entrega', 'data_pago'], 'safe'],
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
            'empresa_fk' => 'Empresa Fk',
            'data_entrega' => 'Data Entrega',
            'data_pago' => 'Data Pago',
            'servico_fk' => 'Servico Fk',
            'quantidade' => 'Quantidade',
            'info' => 'Info',
            'status_pagamento' => 'Status Pagamento',
            'status_servico' => 'Status Servico',
            'usuario_fk' => 'Usuario Fk',
        ];
    }
}
