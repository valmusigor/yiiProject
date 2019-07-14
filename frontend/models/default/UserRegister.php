<?php

namespace frontend\models;

use yii\db\Query;
use Yii;

class UserRegister extends User{
  
    
    
    public static $instance = null;

    public static function getInstanse()
    {
        if(self::$instance===null)
        {
            self::$instance=new UserRegister();
            self::$instance->qB = new Query();
        }
        return self::$instance;
    }
    
    public function rules() {
        return [
        [['login', 'pass', 'email'], 'trim'],
        [['login','pass'], 'string', 'length' => [4, 8]], 
        [['login', 'email'], 'required'],
        ['email', 'email'],     
    ];
   }
   
   public function setUser($formData){
       $this->login=$formData['login'];
       $this->pass=$formData['pass'];
       $this->email=$formData['email'];
   }
   public function getUser(){
       return ['login'=>$this->login,'pass'=>$this->pass,'email'=>$this->email];
   }
    /**
     * 
     * @return boolean
     */
    public function checkExistRegData()
    {
       $result = $this->qB->from('users')
               ->where('login=:login',[':login'=>$this->login])
               ->orWhere('email=:email', [':email'=>$this->email])
               ->createCommand()->queryAll(); 
      if(is_array($result) && count($result)>0){
        return false;
      }
      return true;
    }
/**
 * create new User in table
 * @return string|boolean
 */
    public function insertData()
    {
     if($this->qB->createCommand()->insert('users', [
        'login' => $this->login,
        'pass' => $this->pass,
        'email'=> $this->email,
        'role'=>'user',
      ])->execute()){
        $insertId= Yii::$app->db->getLastInsertID();
        return ($insertId)?$insertId:false;
     }
     return false;
    }
}



