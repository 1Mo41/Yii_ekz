<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $name
 * @property int $role
 * @property string $email
 * @property string $password
 *
 * @property Request[] $requests
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $password_repeat;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'name', 'role', 'email', 'password','password_repeat'], 'required'],
            [['role'], 'integer'],
            ['role', 'default','value'=> 0],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['username','unique'],
            ['username', 'match', 'pattern' => '/^[A-z]\w*$/i','message'=>'Только по инглиш ,пон!?'],
            ['name', 'match', 'pattern' => '/^[А-яЁе -]*$/u','message'=>'Только по Руссиш ,пон!?'],
            ['email','email'],
            [['username', 'name', 'email', 'password'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'name' => 'Name',
            'role' => 'Role',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password',
        ];
    }

    /**
     * Gets query for [[Requests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::class, ['id_user' => 'id']);
    }
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null current user auth key
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @param string $authKey
     * @return bool|null if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }
    public static function findByUsername($username)
    {
        return User::findOne(['username' => $username]);
    }
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }
    public function beforeSave($insert)
    {
        return $this->password = md5($this->password);
    }

    public function isAdmin(){

        return $this->role == 1;

    }
}
