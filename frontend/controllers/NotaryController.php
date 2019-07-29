<?php

namespace frontend\controllers;
use frontend\models\Notary;
use frontend\models\Messages;
use frontend\controllers\behaviors\AccessBehavior;
use \yii\web\Controller;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use frontend\models\SubscribeForm;
use frontend\models\MessageForm;
use common\models\Form;
use \yii\web\UploadedFile;
use frontend\models\FormsNotarys;
use frontend\models\Nfiles;
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
        foreach($notary->formsNotarys as $con)   
        $con->delete();
        foreach ($notary->nfiles as $nfile){
         $nfile->deleteFile();
         $nfile->delete();
        }
        if($notary->delete()){
            Yii::$app->session->setFlash('success', 'Заявка успешно удалена');
        }
        }
        return $this->redirect( Url::to(['notary/index'])); 
        }
        return $this->redirect( Url::to(['notary/index']));
    }
     public function actionView($id)
    {
        if(($model=$this->findModel($id)))
        return $this->render('view', [
            'model' => $model,
        ]);
        return $this->redirect( Url::to(['notary/index']));
    }
    public function actionIndex()
    {
        $modelMessageForm=new MessageForm();
        $dataProvider = new ActiveDataProvider([
            'query' => ((Yii::$app->user->identity->role===1)?
            Notary::find()->where(['client_id'=>Yii::$app->user->identity->id])->joinWith(['nfiles','formsNotarys'])
                : Notary::find()->where(['status'=>1])->orWhere(['notary_id'=>Yii::$app->user->identity->id])),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $form_fields= Form::find()->andWhere(['form_name'=>'requestaddform'])->andWhere(['todelete'=>2])->all();

        if(Yii::$app->user->identity->role===1){
            foreach ($form_fields as $form_field) {
            $atr[]=$form_field->field_name;
            }
            $rules= $this->createRules($form_fields);
            $model = new \yii\base\DynamicModel($atr);
            foreach ($rules as $rule)
            {
             call_user_func_array(array($model,'addRule'), $rule);
            }
        if(Yii::$app->request->isPost && $model->validateData(Yii::$app->request->post()) && $model->load(Yii::$app->request->post()))
        { 
            $notary_model=new Notary();
            $notary_model->createBaseNotary();
            if($notary_model->save()){
            $file_fields= Form::find()->andwhere(['form_name'=>'requestaddform'])->andWhere(['type_field'=>'fileInput'])->andWhere(['todelete'=>2])->all();
            foreach ($file_fields as $file_field){
                $file_obj=UploadedFile::getInstance($model, $file_field->field_name); 
                $nfile_model=new Nfiles();
                $nfile_model->user_id=Yii::$app->user->identity->id;
                $nfile_model->upload_name=$file_obj->baseName;
                $nfile_model->file_name= $nfile_model->upload($file_obj); 
                $nfile_model->link('order', $notary_model);
            }
            foreach ($form_fields as $form_field) {
                $formNotary_model=new FormsNotarys();
                $formNotary_model->forms_id=$form_field->id;
                $formNotary_model->result_string=$model->{"$form_field->field_name"};
                $formNotary_model->link('notary', $notary_model);
            }
            
            Yii::$app->session->setFlash('success', 'REQUEST ADDED');
            }
        }
        return $this->render('index',['dataProvider'=>$dataProvider,'model'=>$model,'modelMessageForm'=>$modelMessageForm,'form_field'=>$form_fields]);
        }
        return $this->render('index',['dataProvider'=>$dataProvider,'modelMessageForm'=>$modelMessageForm,'form_field'=>$form_fields]);
    }

    public function actionUpdate($id)
    {
       
       if(Yii::$app->user->identity->role===1){ 
//        $dataProvider = new ActiveDataProvider([
//            'query' => Notary::find()->where(['client_id'=>Yii::$app->user->identity->id]),
//            'pagination' => [
//                'pageSize' => 20,
//            ],
//        ]);
//        $modelMessageForm=new MessageForm();
        $notary_model= Notary::findOne(['id'=>intval($id),'client_id'=>Yii::$app->user->identity->id]);
        if($notary_model && $notary_model->status===1 ){
        //получаем имена атрибутов для создания новой заявки
        foreach ($notary_model->formsNotarys as $con){
            $atr[]=$con->forms->field_name;
        }
        $atr[]='id';
        
        //формируем правила
        $rules= $this->createRules($notary_model->forms);
        //формируем модель с необходимыми атрибутами
        $model = new \yii\base\DynamicModel($atr);
        //и необходимыми правилами
        foreach ($rules as $rule)
        {
        call_user_func_array(array($model,'addRule'), $rule);
        }
        //грузим старые данные в массив
        $model->id=$id;
        $i=0;
        foreach ($notary_model->formsNotarys as $con){
            if($con->forms->type_field==='fileInput')
            {
                $file_fields[]=$con->forms;
                $model->{"$atr[$i]"}=$notary_model->nfiles[0]->file_name;
                $i++;
                continue;
            }
            $model->{"$atr[$i]"}=$con->result_string;
            $i++;
        }
          if(Yii::$app->request->isPost && $model->validateData(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())){
              foreach ($notary_model->nfiles as $nfile)
              {
                  if(!$nfile->deleteFile() || !$nfile->delete()){
                       Yii::$app->session->setFlash('danger', 'REQUEST UPDATE');
                  return $this->redirect( Url::to(['notary/index']));
                  
                  }
              }
//            $file_fields=$notary_model->nfiles;
            //$file_fields= Form::find()->andwhere(['form_name'=>'requestaddform'])->andWhere(['type_field'=>'fileInput'])->andWhere(['todelete'=>2])->all();
            foreach ($file_fields as $file_field){
                $file_obj=UploadedFile::getInstance($model, $file_field->field_name); 
                $nfile_model=new Nfiles();
                $nfile_model->user_id=Yii::$app->user->identity->id;
                $nfile_model->upload_name=$file_obj->baseName;
                $nfile_model->file_name= $nfile_model->upload($file_obj); 
                $nfile_model->link('order', $notary_model);
            }
            $i=0;
            foreach ($notary_model->formsNotarys as $con) {
                //$formNotary_model=new FormsNotarys();
                //$formNotary_model->forms_id=$form_field->id;
                $con->result_string=$model->{"$atr[$i]"};
                //$con->link('notary', $notary_model);
                $con->update();
                $i++;
            }
                Yii::$app->session->setFlash('success', 'REQUEST UPDATE');
                 return $this->redirect( Url::to(['notary/index']));
           
          }
           return $this->render('update', [
            'model' => $model,'form_fields'=>$notary_model->forms,
        ]);
         //return $this->render('index',['dataProvider'=>$dataProvider,'model'=>$model,'modelMessageForm'=>$modelMessageForm,'form_field'=>$form_field]);
        }
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
            $file_obj=UploadedFile::getInstance($model, 'file_name');
            $nfile_model=new Nfiles();
            $nfile_model->user_id=Yii::$app->user->identity->id;
            $nfile_model->upload_name=$file_obj->baseName;
            $nfile_model->file_name= $nfile_model->upload($file_obj);
            $nfile_model->link('order', $notary);
            if($nfile_model->validate() ){
                $notary->time_create_request=time();
                $notary->status=3;
                if($notary->save()){
                Yii::$app->session->setFlash('success', 'deal has been completed successfully');
                return $this->redirect( Url::to(['notary/index']));
                }
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
            if($notary->client_id!==Yii::$app->user->identity->id && $notary->notary_id!==Yii::$app->user->identity->id)
            return json_encode (false);  
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
            if($notary->client_id!==Yii::$app->user->identity->id && $notary->notary_id!==Yii::$app->user->identity->id)
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
    protected function createRules($form_field){
        $rules=[];
        foreach ($form_field as $field)
        {
         if($field->required===1)   
             $rules[]=[$field->field_name,'required'];
         if($field->uniquie===1)   
             $rules[]=[$field->field_name,'unique'];
         if($field->type_value==='varchar')
             $rules[]=($field->size)?[$field->field_name,'string',['max'=>$field->size]]:[$field->field_name,'string'];
         if($field->type_value==='int')
             $rules[]=[$field->field_name,'integer'];
         if($field->type_field==='fileInput')
         {
             if(is_array($field->extensions)){
                 foreach ($field->extensions as $ext)
                     $extensions[]=$ext;
                 $rules[]=($field->file_size)?[$field->field_name,'file',['extensions' =>$extensions],['maxSize' => intval($field->file_size)] ]
                         :[$field->field_name,'file','extensions' =>$extensions];
             }
             else{
                 $rules[]=($field->file_size)?[$field->field_name,'file',['extensions' =>$field->extensions],['maxSize' => intval($field->file_size) ]]
                         :[$field->field_name,'file','extensions' =>$field->extensions];
             }
         }
        }
        $rules[]=[['time_create_request', 'client_id', 'notary_id', 'status'], 'integer'];
        
        return $rules;
    }
    protected function findModel($id)
    {
        if(Yii::$app->user->identity->role===1){ 
        if (($model = Notary::findOne($id)) !== null && $model->client_id===Yii::$app->user->identity->id) {
            return $model;
        }
        return false;
        }
        else if(($model = Notary::findOne($id)) && $model->status){
            if($model->status===1 || $model->notary_id===Yii::$app->user->identity->id)
                return $model;
            return false;
        }
       return false;
    }
}
