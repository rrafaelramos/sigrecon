<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lembrete".
 *
 * @property int $id
 * @property string $data
 * @property string|null $titulo
 * @property int|null $usuario_fk
 * @property int|null $alerta_pf
 * @property int|null $alerta_pj
 */
class Lembrete extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lembrete';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data', 'titulo'], 'required'],
            [['data'], 'safe'],
            [['usuario_fk','alerta_pf','alerta_pj'], 'integer'],
            [['titulo'], 'string', 'max' => 100],
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
            'titulo' => 'Lembrete',
            'usuario_fk' => 'Usuário',
            'alerta_id' => 'Alerta_id',
        ];
    }
}
