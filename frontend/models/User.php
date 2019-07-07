<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord{
  
    const SCENARIO_REGISTER = 'user register';
    const SCENARIO_LOGIN = 'user login';
    public static function tableName() {
        return '{{users}}';
    }
    public function scenarios() {
        return [
            self::SCENARIO_REGISTER => ['login','pass','email'],
            self::SCENARIO_LOGIN => ['login','pass'],
        ];
    }

    public function rules() {
        return [
        [['login', 'pass', 'email'], 'trim'],
        [['login','pass'], 'string', 'length' => [4, 8]], 
        [['login','pass', 'email'], 'required'],
        ['email', 'email'],      
    ];
   }
}


