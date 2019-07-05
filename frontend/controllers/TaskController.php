<?php

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\{User,Task};
use yii\helpers\Url;
use Yii;

class TaskController extends Controller
{
    private $session; 
    public function __construct($id, $module, $config=array()){
        parent::__construct($id, $module, $config);
        $this->session = Yii::$app->session;
    }
    public function actionIndex($sort=null)
    {
    if($this->session->has('auth') && $this->session->has('id')){
        $auth=$this->session->get('auth');
        $id=$this->session->get('id');
        $user=User::findOne(intval($id));
        if($auth==='ok' && $user){
          if($user->role ==='admin'){
            echo "Hello admin";
            exit();
          }
          $tasks=(($sort==='up')?Task::find(['userId'=>$user->userId])->orderBy(['time_end'=>SORT_ASC])->all():
          Task::find(['userId'=>$user->userId])->orderBy(['time_end'=>SORT_DESC])->all()); 
        return $this->render('index',['tasks'=>$tasks,'login'=>$user->login,'error'=>Yii::$app->request->get('error')]);
        }
    }
    return $this->redirect( Url::to(['user/login'])."?error=Вы+не+авторизованы");
    }
    public function actionMail(){
        $result = Yii::$app->mailer->compose()->setFrom('xraymoby@gmail.com')
        ->setTo('x-ray-moby@mail.ru')->setSubject('Тема сообщения')
        ->setTextBody('Текст сообщения')
        ->setHtmlBody('<b>Текст сообщения в формате HTML</b>')
        ->send();
        var_dump($result);
        exit();                
    }
}

