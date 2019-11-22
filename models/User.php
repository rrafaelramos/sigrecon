<?php

namespace app\models;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $id;
    public $nome;
    public $username;
    public $senha;
    public $telefone;
    public $email;
    public $tipo;
    public $password;
    public $usuario_fk;
    public $authKey;
    public $accessToken;

    public static function tableName(){
        return 'user';
    }

    public function rules()
    {
        return [
            [['nome', 'senha', 'telefone', 'email'], 'required'],
            [['tipo'], 'integer'],
            [['nome'], 'string', 'max' => 120],
            [['senha'], 'string', 'max' => 50],
            [['telefone'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 100],
            [['email'], 'unique'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $user = User::find()->where(['id' => $id])->one();

//        $user = self::find()->where(['id' => $id])->one();
//
        if($user){
            return new static($user);
        }
        return null;
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
//        foreach (self::$users as $user) {
//            if ($user['accessToken'] === $token) {
//                return new static($user);
//            }
//        }
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
//        foreach (self::$users as $user) {
//            if (strcasecmp($user['username'], $username) === 0) {
//                return new static($user);
//            }
//        }
        $user = User::find()->where(['nome' => $username])->one();

        
        if($user){
            return new static ($user);
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->senha === $password;
    }
}
