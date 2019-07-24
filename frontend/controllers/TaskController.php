<?php

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\{User,Task,TaskForm};
use frontend\controllers\behaviors\AccessBehavior;
use yii\helpers\Url;
use Yii;

class TaskController extends Controller
{
    public function behaviors() {
        return [
        AccessBehavior::className(),
        ];
    }
    public function actionIndex($sort=null)
    {
        $user=Yii::$app->user->identity;
          $model=new TaskForm();
          if($model->load(Yii::$app->request->post()) && $model->save($user)){
              Yii::$app->session->setFlash('success', 'Add task');
          }
          $tasks=Task::getTasks($user->id, $sort);
          return $this->render('index',
              ['tasks'=>$tasks,
              'login'=>$user->username,
              'error'=>Yii::$app->request->get('error'),
               'model'=>$model]);
    }
    public function actionUpdate(){
          foreach(Yii::$app->request->get() as $key=>$value){
           if(!($keys=explode("_", $key)) || count($keys)!==2 || !Task::getTask(intval($keys[1]), Yii::$app->user->identity->id)){
                return $this->redirect( Url::to(['task/index'])."?error=Неверные+данные");    
           }
              $results[$keys[1]][$keys[0]]=htmlspecialchars(str_replace('|','',trim($value)));
          }
          foreach ($results as $key =>$value){
              $task=Task::getTask(intval($key),Yii::$app->user->identity->id);
                  if(isset($value['edit']) && isset($value['hour']) && isset($value['minutes']) && isset($value['calendar']))
                  {
                     $formData['text']= $value['edit'];
                     $formData['time_end']=strtotime($value['hour'].':'.$value['minutes'].' '.$value['calendar']);
                     $task->attributes=$formData;
                     if(!$task->validate()){
                       $errors=$task->getErrors();
                       return $this->redirect( Url::to(['task/index']).'?error='.reset($errors)[0]);
                     }
                     $task->update();
                  }
                  else return $this->redirect( Url::to(['task/index'])."?error=Некорректные+данные"); 
          }
         return $this->redirect( Url::to(['task/index']));

    }
      public function actionDelete($deleteId){    
        if(!($task=Task::getTask($deleteId, Yii::$app->user->identity->id))){
          return $this->redirect( Url::to(['task/index'])."?error=Ошибка+удаления");
        }
        if(!$task->delete()){
          return $this->redirect( Url::to(['task/index'])."?error=Ошибка+удаления");    
        }
        Yii::$app->session->setFlash('success', 'Success delete task');
        return $this->redirect( Url::to(['task/index']));
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

