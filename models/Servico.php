<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "servico".
 *
 * @property int $id
 * @property double $valor
 * @property double $valor_minimo
 * @property string $descricao
 */
class Servico extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['valor', 'descricao'], 'required'],
            [['valor', 'valor_minimo'], 'number'],
            [['descricao'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Código',
            'valor' => 'Valor',
            'valor_minimo' => 'Valor Com Desconto',
            'descricao' => 'Descrição',
        ];
    }
}
