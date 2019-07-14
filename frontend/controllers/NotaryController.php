<?php

namespace frontend\controllers;
use frontend\models\Notary;
use \yii\web\Controller;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use frontend\models\RequestAddForm;
use \yii\web\UploadedFile;
use Yii;

class NotaryController extends Controller
{
    public function actionDelete($id)
    { 
        if(Yii::$app->user->isGuest){
          return $this->redirect( Url::to(['user/login'])."?error=Вы+не+авторизованы"); 
        }
        $notary= Notary::findOne(['id'=>intval($id),'client_id'=>Yii::$app->user->identity->id]);
        if($notary && $notary->status===0){
        Notary::deleteFile($notary->file_name);
        if($notary->delete()){
            Yii::$app->session->setFlash('success', 'Заявка успешно удалена');
        }
        }
        return $this->redirect( Url::to(['notary/index'])); 
    }

    public function actionIndex()
    {
         if(Yii::$app->user->isGuest){
          return $this->redirect( Url::to(['user/login'])."?error=Вы+не+авторизованы"); 
        }
       
        $dataProvider = new ActiveDataProvider([
            'query' => Notary::find(['client_id'=>Yii::$app->user->identity->id]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $model=new RequestAddForm();
        $model->scenario= RequestAddForm::SCENARIO_SAVE;
        if(Yii::$app->request->isPost)
        { 
            $model->attributes=Yii::$app->request->post('RequestAddForm');
            $model->file_name= UploadedFile::getInstance($model, 'file_name');
            if($model->save()){
                Yii::$app->session->setFlash('success', 'REQUEST ADDED');
            }
        }
        return $this->render('index',['dataProvider'=>$dataProvider,'model'=>$model]);
    }

    public function actionUpdate($id)
    {
         if(Yii::$app->user->isGuest){
          return $this->redirect( Url::to(['user/login'])."?error=Вы+не+авторизованы"); 
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Notary::find(['client_id'=>Yii::$app->user->identity->id]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $model= Notary::findOne(['id'=>intval($id),'client_id'=>Yii::$app->user->identity->id]);
        $updateModel=new RequestAddForm();
        $updateModel->scenario= RequestAddForm::SCENARIO_UPDATE;
          if($model && $model->status===0 && Yii::$app->request->isPost){
            $updateModel->attributes=Yii::$app->request->post('Notary');
            $updateModel->file_name= UploadedFile::getInstance($model, 'file_name');
            if($updateModel->update($model)){
                Yii::$app->session->setFlash('success', 'REQUEST UPDATE');
            }
          }
         return $this->render('index',['dataProvider'=>$dataProvider,'model'=>$model]);
    }

    public function actionView()
    {    
        if(Yii::$app->user->isGuest){
          return $this->redirect( Url::to(['user/login'])."?error=Вы+не+авторизованы"); 
        }
        return $this->render('view');
    }

}
