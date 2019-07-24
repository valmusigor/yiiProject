<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $verification_token
 */
class User extends ActiveRecord implements IdentityInterface{
  
    const SCENARIO_REGISTER = 'user register';
    const SCENARIO_LOGIN = 'user login';
    public static function tableName() {
        return '{{user}}';
    }
    public function scenarios() {
        return [
            self::SCENARIO_REGISTER => ['username', 'auth_key', 'password_hash','password_reset_token', 'email', 'created_at', 'updated_at','status','role'],
            self::SCENARIO_LOGIN => ['username','password_hash'],
        ];
    }

    public function rules() {
        return [
        [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
        [['status', 'created_at', 'updated_at'], 'integer'],
        [['username'], 'string', 'length' => [4, 8]],
        [[ 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
        [['email'], 'email'],
        [['auth_key'], 'string', 'max' => 32],
        [['username'], 'unique','on' => self::SCENARIO_REGISTER],
        [['email'], 'unique'],
        [['password_reset_token'], 'unique'],
        [['role'],'required','on' => self::SCENARIO_REGISTER]
    ];
    }
     public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
            'role'=>'Role',
        ];
    }
    public static function getUser($username){
        return self::findOne(['username'=>$username]);
    }
    //for rest aplications
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
       //for rest aplications
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
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
    public static function getUsernameById($id){
        return self::findOne($id)->username;
    }
}


