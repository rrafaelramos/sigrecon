<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lembrete".
 *
 * @property int $id
 * @property string $data
 * @property string $info
 * @property int|null $usuario_fk
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
            [['data', 'info'], 'required'],
            [['data'], 'safe'],
            [['info'], 'string'],
            [['usuario_fk'], 'integer'],
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
            'info' => 'Info',
            'usuario_fk' => 'Usuario Fk',
        ];
    }
}
