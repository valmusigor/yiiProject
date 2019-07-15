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
class RequestAddForm extends Model {
    const SCENARIO_SAVE = 'notary save';
    const SCENARIO_UPDATE = 'notary update';
    public  $document_name;
    public $country;
    public $file_name;
     public function scenarios() {
        return [
            self::SCENARIO_SAVE => ['document_name', 'country', 'file_name'],
            self::SCENARIO_UPDATE => ['document_name', 'country', 'file_name'],
        ];
    }
    public function rules()
    {
        return [
         [['document_name','country'],'trim'],
         [['document_name'], 'string', 'max' => 40],
         [['country'], 'string', 'max' => 30],
         [['document_name','country'],'required'],
         [['file_name'],'required','on' => self::SCENARIO_SAVE],   
         ['file_name', 'file', 'extensions' => ['pdf'], 'maxSize' => 1024*1024*2],
        ];
    }
    public function save(){
        if($this->validate())
        {
            $notary=new Notary();
            $notary->document_name= $this->document_name;
            $notary->country= $this->country;
            $notary->file_name=$this->upload();
            $notary->upload_name=$this->file_name->baseName;
            $notary->time_create_request=time();
            $notary->client_id=Yii::$app->user->identity->id;
            $notary->status=1;
            $notary->save();
            return true;
        }
        return false;
    }
     public function update($notary){
         
        if($this->validate())
        {
            $notary->document_name= $this->document_name;
            $notary->country= $this->country;
            if($this->file_name){
              Notary::deleteFile($notary->file_name);
              $notary->file_name=$this->upload();   
              $notary->upload_name=$this->file_name->baseName;
            }
            $notary->time_create_request=time();
            $notary->save();
            return true;
        }
        return false;
    }
    public  function upload(){
           $file_name=md5($this->file_name->baseName.rand(1,99).time()).'.'.$this->file_name->extension;
           if(!file_exists(Yii::getAlias('@uploadNotary').'/'.$file_name[0]))
           mkdir(Yii::getAlias('@uploadNotary').'/'.$file_name[0],0777, true);
           $this->file_name->saveAs(Yii::getAlias('@uploadNotary').'/'.$file_name[0].'/'.$file_name);
           return $file_name;
   }
}
