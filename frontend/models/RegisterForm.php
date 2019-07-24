<?php

namespace frontend\models;

use frontend\models\User;
use  yii\base\Model;
use Yii;

class RegisterForm extends Model{
 public $username;
 public $pass;
 public $email; 
 public $role;
 public function rules() {
     return
     [
         [['username','pass','email'],'trim'],
         [['username','pass','email','role'],'required'],
         [['username','pass'],'string','min'=>4,'max'=>10],
         [['email'],'email'],
         [['email','username'], 'unique','targetClass' => User::className()],
         
     ];
 }
 public function save() {
     if($this->validate()){
        $user=new User();
        $user->scenario= User::SCENARIO_REGISTER;
        $user->username=$this->username;
        $user->email=$this->email;
        $time= time();
        $user->created_at=$time;
        $user->updated_at=$time;
        $user->auth_key= Yii::$app->security->generateRandomString();
        $user->password_hash = Yii::$app->security->generatePasswordHash($this->pass);
        $user->role= intval($this->role);
        if($user->save())
        {
          Yii::$app->user->login($user);
          return true;
        }
        return false;
     }
     return false;
 }
}

