<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mensagem".
 *
 * @property int $id
 * @property int|null $emissor
 * @property int|null $receptor
 * @property string|null $data_envio
 * @property string|null $titulo
 * @property string|null $conteudo
 * @property int|null $lido
 */
class Mensagem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mensagem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emissor', 'receptor', 'lido'], 'integer'],
            [['data_envio'], 'safe'],
            [['conteudo'], 'string'],
            [['titulo'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'emissor' => 'Emissor',
            'receptor' => 'Receptor',
            'data_envio' => 'Data Envio',
            'titulo' => 'Titulo',
            'conteudo' => 'Conteudo',
            'lido' => 'Lido',
        ];
    }
}
