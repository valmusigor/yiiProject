<?php

namespace frontend\models;
use yii\base\Model;
use frontend\models\User;
use Yii;
/**
 * Description of LoginForm
 *
 * @author igor
 */
class LoginForm extends Model  {
    public $username;
    public $pass;
    public function rules() {
        return[
         [['username','pass'],'trim'],
         [['username','pass'],'required'],
         [['username'],'exist','targetAttribute' => ['username'],'targetClass' => User::className()],
         [['username','pass'],'string','min'=>4,'max'=>10],
         ['pass','validatePassword'],
     ];
    }
    public function login(){
        if($this->validate()){
            $user=User::getUser($this->username);
            Yii::$app->user->login($user);
            return true;
        }
        return false;
    }
    public function validatePassword($attribute,$params){
       $user=User::getUser($this->username);
       if(!$user || !Yii::$app->security->validatePassword($this->pass, $user->password_hash))
       {
           $this->addError($attribute, 'Вы ввели неверный пароль');
           return false;
       }
       return true;
    }
    
}   
    