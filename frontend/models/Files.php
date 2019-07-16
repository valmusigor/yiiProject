<?php

namespace frontend\models;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use Yii;

class Files extends ActiveRecord{
   public static function tableName() {
       return '{{files}}';
   }
   public function rules() {
     return [
         ['name','required'],
         ['name', 'file', 'extensions' => ['png', 'jpg', 'gif','jpeg'], 'maxSize' => 1024*1024*2]
     ];
   }
   public  function upload(){
       if($this->validate()){
           $this->uploadName=$this->name->baseName.'.'.$this->name->extension;
           $fileName=md5($this->name->baseName.rand(1,99).time()).'.'.$this->name->extension;
           if(!file_exists(Yii::getAlias('@uploadImages').'/'.$fileName[0]))
           mkdir(Yii::getAlias('@uploadImages').'/'.$fileName[0],0777, true);
           $this->name->saveAs(Yii::getAlias('@uploadImages').'/'.$fileName[0].'/'.$fileName);
           $this->downloadName= substr($fileName, 0,5).'.'.$this->name->extension;
           $this->name=$fileName;
           $this->userId=Yii::$app->user->identity->id;
           if($this->save())
           return true;
       }
       return false;
   }
   public static function getFile($id,$userId){
       return Files::findOne(['fileId'=>$id,'userId'=>$userId]);
   }
   public static function deleteFile($file_name){
       $path=Yii::getAlias('@uploadImages').'/'.$file_name[0].'/'.$file_name;
        if(file_exists($path) && unlink($path)){
            return true;
        }
        return false;
   }
}
