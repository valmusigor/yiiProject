<?php

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\User;
use yii\helpers\Url;
use Yii;
/**
 * @author igor
 */
class SiteController extends Controller {
    private $session; 
    public function __construct($id, $module, $config=array()){
        parent::__construct($id, $module, $config);
        $this->session = Yii::$app->session;
    }
    public function actionIndex(){
     if($this->session->has('auth') && $this->session->has('id')){
        $auth=$this->session->get('auth');
        $id=$this->session->get('id');
        $user=User::findOne(intval($id));
        if($auth==='ok' && $user){
          if($user->role ==='admin'){
            echo "Hello admin";
           // exit();
          }
        return $this->render('index',['login'=>$user->login]);
        }
    }
   return $this->redirect( Url::to(['user/login'])."?error=Вы+не+авторизованы");

  }
  public function actionAdmin(){
    $result=User::Autorize();
    if(!$result){
      header('Location:/login?error=Вы+неавторизированы');
      exit();
    }
    if(isset($result['access']) && $result['access']==='1')
      echo "<h1>Hello ADMIN!</h1>";
    else header('Location:/');
    require_once('./views/adminPage/index.php');
  }
}
