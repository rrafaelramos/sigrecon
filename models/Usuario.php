<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

class Usuario extends \yii\db\ActiveRecord implements IdentityInterface
{

    public static function tableName()
    {
        return 'usuario';
    }

    public function rules()
    {
        return [
            [['tipo'], 'integer'],
            [['username', 'password', 'authKey'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 50],
            [['nome'], 'string', 'max' => 200],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'tipo' => 'Tipo',
            'authKey' => 'Authkey',
            'nome' =>'Nome;'
        ];
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public static function findByUsername($username){
        return self::findOne(['username' => $username]);
    }

    public function validatePassword($password){
        return $this->password === $password;
    }
}
