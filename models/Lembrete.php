<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lembrete".
 *
 * @property int $id
 * @property string $data
 * @property string|null $titulo
 * @property string $corpo
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
            [['data', 'titulo'], 'required'],
            [['data'], 'safe'],
            [['usuario_fk'], 'integer'],
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
            'titulo' => 'Titulo',
            'corpo' => 'Corpo',
            'usuario_fk' => 'Usuario Fk',
        ];
    }
}
