<?php

namespace frontend\controllers;
use frontend\models\{RegisterForm, User, LoginForm};
use yii\web\Controller;
use yii\helpers\Url;
use Yii;

class UserController extends Controller{
    public function actionLogin(){
        if(!Yii::$app->user->isGuest){
            if(Yii::$app->user->identity->role===3)
                 return $this->redirect( Url::to(['/admin']));
           return $this->redirect( Url::to(['site/index'])); 
        }
        $model= new LoginForm();
        if($model->load(Yii::$app->request->post()) && $model->login()){
            if(Yii::$app->user->identity->role===3)
                 return $this->redirect( Url::to(['site/index']));
            return $this->redirect( Url::to(['site/index']));
        }
        return $this->render('login',['model'=>$model]);
  }
  public function actionLogout(){
      if(Yii::$app->user->isGuest){
           return $this->redirect( Url::to(['user/login'])."?error=Вы+не+авторизованы"); 
        }
        Yii::$app->user->logout();
        return $this->redirect( Url::to(['user/login']));
    
  }
  public function actionRegister(){
    if(!Yii::$app->user->isGuest){
        if(Yii::$app->user->identity->role===3)
                 return $this->redirect( Url::to(['site/index']));
           return $this->redirect( Url::to(['site/index'])); 
        }
    $model= new RegisterForm();
    if($model->load(Yii::$app->request->post()) && $model->save()){
        
        return $this->redirect( Url::to(['site/index']));
    }
    return $this->render('register',['model'=>$model]);
}
    public function actionAdmin(){
        if(Yii::$app->user->identity->role!==3){
           return $this->redirect( Url::to(['site/index'])); 
        }
        //return $this->render('admin');
         return $this->redirect( Url::to(['site/index']));
    }
}

