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
        $id=$this->session->get('id');
        $user=User::findOne(intval($id));
        if($this->session->get('auth')==='ok' && $user){
          if($user->role ==='admin'){
            echo "Hello admin";
            exit();
          }
          $tasks=(($sort==='up')?Task::find()->where(['userId'=>$user->userId])->orderBy(['time_end'=>SORT_ASC])->all():
          Task::find()->where(['userId'=>$user->userId])->orderBy(['time_end'=>SORT_DESC])->all()); 
        return $this->render('index',['tasks'=>$tasks,'login'=>$user->login,'error'=>Yii::$app->request->get('error')]);
        }
    }
    return $this->redirect( Url::to(['user/login'])."?error=Вы+не+авторизованы");
    }
    public function actionSave() {
        if($this->session->has('auth') && $this->session->has('id')){
        $id=$this->session->get('id');
        $user=User::findOne(intval($id));
        if($this->session->get('auth')==='ok' && $user){
          if($user->role ==='admin'){
            echo "Hello admin";
            exit();
          }
        $formData['text']= Yii::$app->request->get('task');
        $formData['time_end']=strtotime(Yii::$app->request->get('hour')
                 .':'.Yii::$app->request->get('minutes')
                .' '.Yii::$app->request->get('calendar'));
        $model= new Task();
        $model->attributes=$formData;
        if(!$model->validate()){
          $errors=$model->getErrors();
          return $this->redirect( Url::to(['task/index']).'?error='.reset($errors)[0]);
        }
        $model->time_create=strtotime(date("Y-m-d H:i:s"));
        $model->userId=$user->userId;
        $task=$model->save();
        if(!$task){
        return $this->redirect( Url::to(['task/index'])."?Ошибка+записи");   
        }
         return $this->redirect( Url::to(['task/index']));
        }
    }
    return $this->redirect( Url::to(['user/login'])."?error=Вы+не+авторизованы");
    }
    
    public function actionUpdate(){
      if($this->session->has('auth') && $this->session->has('id')){
        $id=$this->session->get('id');
        $user=User::findOne(intval($id));
        if($this->session->get('auth')==='ok' && $user){
          if($user->role ==='admin'){
            echo "Hello admin";
            exit();
          }
          foreach(Yii::$app->request->get() as $key=>$value)
            $results[explode("_", $key)[1]][explode("_", $key)[0]]=htmlspecialchars(str_replace('|','',trim($value)));
          foreach ($results as $key =>$value){
              $task=Task::findOne(['taskId'=>intval($key),'userId'=>$user->userId]);
              if($task){
                  if(isset($value['edit']) && isset($value['hour']) && isset($value['minutes']) && isset($value['calendar']))
                  {
                     $formData['text']= $value['edit'];
                     $formData['time_end']=strtotime($value['hour'].':'.$value['minutes'].' '.$value['calendar']);
                     $task->attributes=$formData;
                     if(!$task->validate()){
                       $errors=$task->getErrors();
                       return $this->redirect( Url::to(['task/index']).'?error='.reset($errors)[0]);
                     }
                     $update=$task->update();
                     return $this->redirect( Url::to(['task/index']));
                  }
                  return $this->redirect( Url::to(['task/index'])."?Некорректные+данные"); 
              }
              return $this->redirect( Url::to(['task/index'])."?Доступ+закрыт");
          }
        }
    }
    return $this->redirect( Url::to(['user/login'])."?error=Вы+не+авторизованы");
    }
      public function actionDelete($deleteId){
      if($this->session->has('auth') && $this->session->has('id')){
        $id=$this->session->get('id');
        $user=User::findOne(intval($id));
        if($this->session->get('auth')==='ok' && $user){
          if($user->role ==='admin'){
            echo "Hello admin";
            exit();
          }
      $task=Task::findOne(['taskId'=>intval($deleteId),'userId'=>$user->userId]);
      if(!$task){
        return $this->redirect( Url::to(['task/index'])."?Ошибка+удаления");
      }
      if(!$task->delete()){
        return $this->redirect( Url::to(['task/index'])."?Ошибка+удаления");    
      }
      
                     return $this->redirect( Url::to(['task/index']));
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

