<?php

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\{User,Files};
use frontend\controllers\behaviors\AccessBehavior;
use yii\helpers\Url;
use \yii\web\UploadedFile;
use Yii;
/**
 * Description of FileController
 *
 * @author igor
 */
class FileController extends Controller {
    public function behaviors() {
        return [
        AccessBehavior::className(),
        ];
    }
    public function actionIndex(){
       $model=new Files();
       $files=Files::find()->where(['userId'=>Yii::$app->user->identity->id])->all();
       if(Yii::$app->request->isPost)
        {
            $model->name= UploadedFile::getInstance($model, 'name');
            if($model->upload()){
                Yii::$app->session->setFlash('success', 'FILE UPLODED');
                return $this->redirect( Url::to(['file/index']));
            }
        }
       return $this->render('index',['model'=>$model,'files'=>$files]);
    }   

    public function actionDelete($deleteId){
     
      if(!($file=Files::getFile(intval($deleteId),Yii::$app->user->identity->id))){
        return $this->redirect( Url::to(['file/index'])."?error=Ошибка+удаления");
      }
      if(Files::deleteFile($file->name) && $file->delete())
      {
          Yii::$app->session->setFlash('success', 'FILE DELETED');
          return $this->redirect( Url::to(['file/index']));
      }
      return $this->redirect( Url::to(['file/index'])."?Ошибка+удаления");    
    }
     public function actionDownload($downloadId){
      
        if(!($file=Files::getFile(intval($downloadId),Yii::$app->user->identity->id))){
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
        else return $this->redirect( Url::to(['file/index'])."?error=Ошибка+загрузки+файла");
    }
}
