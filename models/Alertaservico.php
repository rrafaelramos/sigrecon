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
            [['data_entrega'],'required'],
            [['data_entrega', 'data_pago'], 'safe'],
            [['info'], 'string'],
            [['status_pagamento'], 'required'],
            [['data_entrega'], 'validarData', 'on' => 'criar'],
            [['data_entrega'], 'safe', 'on' => 'atualiza'],
            [['servico_fk'], 'required']
        ];
    }

    public function validarData($attribute, $params, $validator)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $data = date("Y-m-d");

        if (strtotime($this->$attribute) < strtotime($data)) {
            $formatar = date("d/m/Y");
            $this->addError($attribute, 'A data deve ser maior ou igual a: ' . $formatar);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cliente_fk' => 'Cliente',
            'data_entrega' => 'Data de Entrega',
            'servico_fk' => 'Serviço',
            'quantidade' => 'Quantidade',
            'info' => 'Info',
            'status_pagamento' => 'Pagamento',
            'status_servico' => 'Status Servico',
            'usuario_fk' => 'Usuario',
            'data_pago' => 'data pago',
        ];
    }
}
