<?php

namespace app\models;
use app\models\DBUser;

use Yii;

/**
 * This is the model class for table "compra".
 *
 * @property int $id
 * @property int $usuario_fk
 * @property int $quantidade
 * @property string $data
 * @property double $valor
 * @property string $descricao
 *
 * @property User $usuarioFk
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
            [['quantidade', 'data', 'valor', 'descricao'], 'required'],
            [['data'], 'safe'],
            [['valor'], 'number'],
            [['descricao'], 'string', 'max' => 200],
            [['usuario_fk'], 'exist', 'skipOnError' => true, 'targetClass' => DBUser::className(), 'targetAttribute' => ['usuario_fk' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Número',
            'usuario_fk' => 'Usuário',
            'quantidade' => 'Quantidade',
            'data' => 'Data',
            'valor' => 'Valor',
            'descricao' => 'Descrição',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioFk()
    {
        return $this->hasOne(DBUser::className(), ['id' => 'usuario_fk']);
    }
}
