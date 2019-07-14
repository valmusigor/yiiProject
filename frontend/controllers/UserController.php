<?php

namespace frontend\controllers;
use frontend\models\{RegisterForm, User, LoginForm};
use yii\web\Controller;
use yii\helpers\Url;
use Yii;

class UserController extends Controller{
//    private $session; 
//    public function __construct($id, $module, $config=array()){
//        parent::__construct($id, $module, $config);
//        $this->session = Yii::$app->session;
//    }
//    public function actionAuth(){
//    if($this->session->has('auth') && $this->session->has('id')){
//        $auth=$this->session->get('auth');
//        $id=$this->session->get('id');
//        $user=User::findOne(intval($id));
//        if($auth==='ok' && $user){
//          if($user->role ==='admin'){
//            echo "Hello admin";
//            exit();
//          }
//        return $this->redirect( Url::to(['site/index']));
//        }
//    }
//    $model= new User();
//    $model->scenario=User::SCENARIO_LOGIN;
//    $formData= Yii::$app->request->post();
//    $model->attributes=$formData;
//    if(!$model->validate()){
//      $errors=$model->getErrors();
//      return $this->redirect( Url::to(['user/login']).'?error='.reset($errors)[0]);
//    }
//    $user=User::findOne(['login'=>$model->login,'pass'=>$model->pass]);
//    if(!$user){
//      return $this->redirect( Url::to(['user/login'])."?error=Пользователь+с+такими+данными+не+найден&login={$formData['login']}&pass={$formData['pass']}");   
//    }
//    $this->session->set('auth', 'ok');
//    $this->session->set('id', $user->userId);
//    if($user->role ==='admin') {
//         echo "hello admin";
//         exit();
//    }
//    else
//       return $this->redirect( Url::to(['site/index']));
//  }
    public function actionLogin(){
        if(!Yii::$app->user->isGuest){
           return $this->redirect( Url::to(['site/index'])); 
        }
        $model= new LoginForm();
        if($model->load(Yii::$app->request->post()) && $model->login()){
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
           return $this->redirect( Url::to(['site/index'])); 
        }
    $model= new RegisterForm();
    if($model->load(Yii::$app->request->post()) && $model->save()){
        
        return $this->redirect( Url::to(['site/index']));
    }
    return $this->render('register',['model'=>$model]);
}
/*public function actionAdd(){
    if($this->session->has('auth') && $this->session->has('id')){
        $auth=$this->session->get('auth');
        $id=$this->session->get('id');
        $user=User::findOne(intval($id));
        if($auth==='ok' && $user){
          if($user->role ==='admin'){
            echo "Hello admin";
            exit();
          }
        return $this->redirect( Url::to(['site/index']));
        }
    }
    $model= new User();
    $model->scenario=User::SCENARIO_REGISTER;
    $formData= Yii::$app->request->post();
    $model->attributes=$formData;
    if(!$model->validate()){
      $errors=$model->getErrors();
      return $this->redirect( Url::to(['user/register']).'?error='.reset($errors)[0]);
    }
    
    if(User::find()->where(['email' => $model->email])->orWhere(['login' => $model->login])->exists()){
      return $this->redirect( Url::to(['user/register'])."?error=Пользователь+с+такими+данными+существует");   
    }
    $user=$model->save();
    if(!$user){
       return $this->redirect( Url::to(['user/register']));
    }
        $this->session->set('auth', 'ok');
        $this->session->set('id', $model->userId);
        return $this->redirect( Url::to(['site/index']));
 }*/
}

