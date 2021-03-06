<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vendapj".
 *
 * @property int $id
 * @property string|null $data
 * @property int|null $empresa_fk
 * @property int|null $usuario_fk
 * @property int $servico_fk
 * @property int $quantidade
 * @property int $form_pagamento
 * @property float|null $total
 * @property float|null $desconto
 * @property float|null $tot_sem_desconto
 *
 *
 * @property Servico $servicoFk
 */
class Vendapj extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vendapj';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data'], 'safe'],
            [['empresa_fk', 'usuario_fk', 'servico_fk', 'quantidade', 'form_pagamento'], 'integer'],
            [['servico_fk', 'quantidade'], 'required'],
            [['total','desconto','tot_sem_desconto'], 'number'],
            [['servico_fk'], 'exist', 'skipOnError' => true, 'targetClass' => Servico::className(), 'targetAttribute' => ['servico_fk' => 'id']],
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
            'empresa_fk' => 'Empresa',
            'usuario_fk' => 'Usuário',
            'servico_fk' => 'Serviço',
            'quantidade' => 'Quantidade',
            'total' => 'Total',
            'desconto' => 'desconto',
            'tot_sem_desconto' => 'Total sem desconto',
            'form_pagamento' => 'Pagamento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicoFk()
    {
        return $this->hasOne(Servico::className(), ['id' => 'servico_fk']);
    }
}
