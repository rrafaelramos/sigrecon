<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "venda".
 *
 * @property int $id
 * @property string $data
 * @property int|null $cliente_fk
 * @property int $usuario_fk
 * @property int $form_pagamento
 * @property int $servico_fk
 * @property int $quantidade
 * @property float|null $total
 * @property float|null $desconto
 * @property float|null $tot_sem_desconto
 *
 * @property Usuario $usuarioFk
 * @property Servico $servicoFk
 */
class Venda extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'venda';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['servico_fk', 'quantidade','form_pagamento'], 'required'],
            [['data'], 'safe'],
            [['cliente_fk', 'usuario_fk', 'servico_fk', 'quantidade', 'form_pagamento'], 'integer'],
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
            'cliente_fk' => 'Cliente Avulso',
            'usuario_fk' => 'Usuario Logado',
            'servico_fk' => 'Servico',
            'quantidade' => 'Quantidade',
            'total' => 'Total',
            'desconto' => 'Desconto',
            'tot_sem_desconto' => 'Total Geral',
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
