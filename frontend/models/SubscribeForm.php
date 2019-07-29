<?php

namespace frontend\models;
use yii\base\Model;
use frontend\models\Notary;
use Yii;
/**
 * Description of RequestAddForm
 *
 * @author igor
 */
class SubscribeForm extends Model {
    public $file_name;
    public function rules()
    {
        return [
         [['file_name'],'required'],   
         ['file_name', 'file', 'extensions' => ['pdf'], 'maxSize' => 1024*1024*2],
        ];
    }
//     public function subscribe($notary){
//         
//        if($this->validate())
//        {
//            if($this->file_name){
//              Notary::deleteFile($notary->file_name);
//              $notary->file_name=$this->upload();   
//              $notary->upload_name=$this->file_name->baseName;
//            }
//            
//            return true;
//        }
//        return false;
//    }
//    public  function upload(){
//           $file_name=md5($this->file_name->baseName.rand(1,99).time()).'.'.$this->file_name->extension;
//           if(!file_exists(Yii::getAlias('@uploadNotary').'/'.$file_name[0]))
//           mkdir(Yii::getAlias('@uploadNotary').'/'.$file_name[0],0777, true);
//           $this->file_name->saveAs(Yii::getAlias('@uploadNotary').'/'.$file_name[0].'/'.$file_name);
//           return $file_name;
//   }
}
