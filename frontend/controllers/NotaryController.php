<?php

namespace frontend\controllers;
use frontend\models\Notary;
use frontend\models\Messages;
use frontend\controllers\behaviors\AccessBehavior;
use \yii\web\Controller;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use frontend\models\RequestAddForm;
use frontend\models\SubscribeForm;
use frontend\models\MessageForm;
use \yii\web\UploadedFile;
use Yii;

class NotaryController extends Controller
{
    public function behaviors() {
        return [
        AccessBehavior::className(),
        ];
    }
    public function actionDelete($id)
    { 
        if(Yii::$app->user->identity->role===1){
        $notary= Notary::findOne(['id'=>intval($id),'client_id'=>Yii::$app->user->identity->id]);
        if($notary && $notary->status===1){
        Notary::deleteFile($notary->file_name);
        if($notary->delete()){
            Yii::$app->session->setFlash('success', 'Заявка успешно удалена');
        }
        }
        return $this->redirect( Url::to(['notary/index'])); 
        }
        return $this->redirect( Url::to(['notary/index']));
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ((Yii::$app->user->identity->role===1)?
            Notary::find()->where(['client_id'=>Yii::$app->user->identity->id])
                : Notary::find()->where(['status'=>1])->orWhere(['notary_id'=>Yii::$app->user->identity->id])),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        if(Yii::$app->user->identity->role===1){
        $model=new RequestAddForm();
        $modelMessageForm=new MessageForm();
        $model->scenario= RequestAddForm::SCENARIO_SAVE;
        if(Yii::$app->request->isPost)
        { 
            $model->attributes=Yii::$app->request->post('RequestAddForm');
            $model->file_name= UploadedFile::getInstance($model, 'file_name');
            if($model->save()){
                Yii::$app->session->setFlash('success', 'REQUEST ADDED');
            }
        }
        return $this->render('index',['dataProvider'=>$dataProvider,'model'=>$model,'modelMessageForm'=>$modelMessageForm]);
        }
         return $this->render('index',['dataProvider'=>$dataProviderl,'modelMessageForm'=>$modelMessageForm]);
    }

    public function actionUpdate($id)
    {
       if(Yii::$app->user->identity->role===1){ 
        $dataProvider = new ActiveDataProvider([
            'query' => Notary::find(['client_id'=>Yii::$app->user->identity->id]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $model= Notary::findOne(['id'=>intval($id),'client_id'=>Yii::$app->user->identity->id]);
        $updateModel=new RequestAddForm();
        $updateModel->scenario= RequestAddForm::SCENARIO_UPDATE;
          if($model && $model->status===1 && Yii::$app->request->isPost){
            $updateModel->attributes=Yii::$app->request->post('Notary');
            $updateModel->file_name= UploadedFile::getInstance($model, 'file_name');
            if($updateModel->update($model)){
                Yii::$app->session->setFlash('success', 'REQUEST UPDATE');
            }
          }
         return $this->render('index',['dataProvider'=>$dataProvider,'model'=>$model]);
       }
       return $this->redirect( Url::to(['notary/index']));
    }
    public function actionSubscribe($id){
        if(Yii::$app->user->identity->role===1 || !($status=Notary::getStatus($id)) ){
            return $this->redirect( Url::to(['notary/index']));
        }
        if($status===1 || ($status===2 && Yii::$app->user->identity->id===Notary::getNotaryId($id))){
             $notary= Notary::findOne(['id'=>$id]);
        $model=new SubscribeForm();
         if($notary && $notary->status===2 && Yii::$app->request->isPost){
            $model->file_name= UploadedFile::getInstance($model, 'file_name');
            if($model->subscribe($notary)){
                Yii::$app->session->setFlash('success', 'deal has been completed successfully');
                return $this->redirect( Url::to(['notary/index']));
            }
          }
        $notary->status=2;
        $notary->notary_id=Yii::$app->user->identity->id;
        $notary->save();
        return $this->render('subscribe',['model'=>$model,'notary'=>$notary]);   
        }
        return $this->redirect( Url::to(['notary/index']));
        
    }
    public function actionCancel($id){
        if(Yii::$app->user->identity->role===1 || !($status=Notary::getStatus($id)) || $status!==2 || Yii::$app->user->identity->id!== Notary::getNotaryId($id)){
            return $this->redirect( Url::to(['notary/index']));
        }
        $notary= Notary::findOne(['id'=>$id]);
        $notary->status=1;
        $notary->notary_id=Null;
        $notary->save();
        return $this->redirect( Url::to(['notary/index']));
    }
    public function actionRepeat($id)
    {    
        return $this->redirect( Url::to(['notary/subscribe']).'?id='.$id);  
    }
    public function actionMessage($id){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $notary = Notary::getNotary($id);
        if(!$notary) return json_encode (FALSE);
        if($notary->status===2 || $notary->status===3){
            if($notary->client_id!==Yii::$app->user->identity->id && $notary->client_id!==Yii::$app->user->identity->id)
            return json_encode (FALSE);  
        }
        $messages= Messages::getMessagesByNotary($id);
        foreach ($messages as $message){
            $result[]=[
                'text_message'=>$message->text_message,
                'time_create'=>$message->time_create,
                'sender'=> \frontend\models\User::getUsernameById($message->sender_id),
            ];
        }
        if($messages){
            
            return json_encode($result); 
        }
        else json_encode (FALSE);
    }
    public function actionSendmessage($notary_request_id,$text_message){
         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        if(!$text_message) return json_encode (FALSE);
        $notary = Notary::getNotary($notary_request_id);
        if(!$notary) return json_encode (FALSE);
        if($notary->status===2 || $notary->status===3){
            if($notary->client_id!==Yii::$app->user->identity->id && $notary->client_id!==Yii::$app->user->identity->id)
            return json_encode (FALSE);  
        }
        $message = new Messages();
        $message->text_message=$text_message;
        $message->time_create= time();
        $message->sender_id=Yii::$app->user->identity->id;
        $message->notary_request_id=$notary_request_id;
        if($message->save())
        return json_encode (TRUE); 
           return json_encode (FALSE); 
    }

}
