<?php

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\{User,Files};
use yii\helpers\Url;
use \yii\web\UploadedFile;
use Yii;
/**
 * Description of FileController
 *
 * @author igor
 */
class FileController extends Controller {
    private $session; 
    public function __construct($id, $module, $config=array()){
        parent::__construct($id, $module, $config);
        $this->session = Yii::$app->session;
    }
    public function actionIndex(){
        
    if($this->session->has('auth') && $this->session->has('id')){
        $id=$this->session->get('id');
        $user=User::findOne(intval($id));
        if($this->session->get('auth')==='ok' && $user){
          if($user->role ==='admin'){
            echo "Hello admin";
            exit();
        }
       $model=new Files();
       $files=Files::find()->where(['userId'=>$user->userId])->all();
       return $this->render('index',['model'=>$model,'files'=>$files]);
      }
    }
   return $this->redirect( Url::to(['user/login'])."?error=Вы+не+авторизованы");
    }   
    
   public function actionUpload(){
   if($this->session->has('auth') && $this->session->has('id')){
        $id=$this->session->get('id');
        $user=User::findOne(intval($id));
        if($this->session->get('auth')==='ok' && $user){
          if($user->role ==='admin'){
            echo "Hello admin";
            exit();
        }
        $model=new Files();
        if(Yii::$app->request->isPost)
        {
            $model->name= UploadedFile::getInstance($model, 'name');
            if($model->upload()){
                $model->userId=$user->userId;
                $model->save();
                return $this->redirect( Url::to(['file/index']));
            }
        }
        return $this->redirect( Url::to(['file/index'])."?error=Ошибка+загрузки+файла");
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
       $file=Files::findOne(['fileId'=>intval($deleteId),'userId'=>$user->userId]);
      if(!$file){
        return $this->redirect( Url::to(['file/index'])."?error=Ошибка+удаления");
      }
      $path=Yii::getAlias('@uploadImages').'/'.$file->name[0].'/'.$file->name;
        if(!file_exists($path)){
            return $this->redirect( Url::to(['file/index'])."?error=Файл+не+существует");
        }
        if(!unlink($path)){
          return $this->redirect( Url::to(['file/index'])."?Ошибка+удаления"); 
        }
        else{
          if(!$file->delete()){
            return $this->redirect( Url::to(['file/index'])."?Ошибка+удаления");    
            }
        }
        return $this->redirect( Url::to(['file/index']));
        
    }
    }
   return $this->redirect( Url::to(['user/login'])."?error=Вы+не+авторизованы");
        }
     public function actionDownload($downloadId){
      if($this->session->has('auth') && $this->session->has('id')){
        $id=$this->session->get('id');
        $user=User::findOne(intval($id));
        if($this->session->get('auth')==='ok' && $user){
          if($user->role ==='admin'){
            echo "Hello admin";
            exit();
        }
        $file=Files::findOne(['fileId'=>$downloadId, 'userId'=>$user->userId]);
        if(!$file){
          header('Location:index.php?error=Файл+не+найден');
          return $this->redirect( Url::to(['file/index'])."?error=Файл+не+найден");
        }
         $path=Yii::getAlias('@uploadImages').'/'.$file->name[0].'/'.$file->name;
          if(file_exists($path) && explode('/',mime_content_type($path)[0]==='image')){
          $fileArr=explode('/',$path);
          header("Content-Description: File Transfer\r\n");
          header("Pragma: public\r\n");
          header("Expires: 0\r\n");
          header("Cache-Control: must-revalidate, post-check=0, pre-check=0\r\n");
          header("Cache-Control: public\r\n");
          header("Content-Type:".mime_content_type($path).";\r\n");
          header("Content-Disposition: attachment; filename=\"".$file->uploadName."\"\r\n");
          readfile($path);
   }
        else return $this->redirect( Url::to(['file/index'])."?error=Ошибка+загрузки+файла");;

          }
    }
   return $this->redirect( Url::to(['user/login'])."?error=Вы+не+авторизованы");
    }
}
