<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "compra".
 *
 * @property int $id
 * @property int|null $usuario_fk
 * @property int $quantidade
 * @property string|null $data
 * @property float $valor
 * @property string $descricao
 *
 * @property Usuario $usuarioFk
 */
class Compra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'compra';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_fk', 'quantidade'], 'integer'],
            [['quantidade', 'valor', 'descricao'], 'required'],
            [['data'], 'safe'],
            [['valor'], 'number'],
            [['descricao'], 'string', 'max' => 200],
            [['usuario_fk'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_fk' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_fk' => 'Usuario Fk',
            'quantidade' => 'Quantidade',
            'data' => 'Data',
            'valor' => 'Valor',
            'descricao' => 'Descricao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioFk()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_fk']);
    }
}
