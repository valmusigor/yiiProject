<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "notary".
 *
 * @property int $id
 * @property string $document_name
 * @property string $country
 * @property string $file_name
 * @property int $time_create_request
 * @property int $client_id
 * @property int $notary_id
 * @property int $status
 */
class Notary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules=[];
        $form_field= Forms::find()->where(['form_name'=>'requestaddform'])->all();
        foreach ($form_field as $field)
        {
         if($field->required===1)   
             $rules[]=[$field->field_name,'required'];
         if($field->uniquie===1)   
             $rules[]=[$field->field_name,'unique'];
         if($field->type_value==='varchar')
             $rules[]=($field->size)?[$field->field_name,'string','max'=>$field->size]:[$field->field_name,'string'];
         if($field->type_value==='int')
             $rules[]=[$field->field_name,'integer'];
         if($field->type_field==='fileInput')
         {
             if(is_array($field->extensions)){
                 foreach ($field->extensions as $ext)
                     $extensions[]=$ext;
                 $rules[]=($field->file_size)?[$field->field_name,'file','extensions' =>$extensions,'maxSize' =>$field->file_size ]
                         :[$field->field_name,'file','extensions' =>$extensions];
             }
             else{
                 $rules[]=($field->file_size)?[$field->field_name,'file','extensions' =>$field->extensions,'maxSize' =>$field->file_size ]
                         :[$field->field_name,'file','extensions' =>$field->extensions];
             }
         }
        }
        $rules[]=[['time_create_request', 'client_id', 'notary_id', 'status'], 'integer'];
        
        return $rules;
//        [
//            [['time_create_request', 'client_id', 'notary_id', 'status'], 'integer'],
//            [['document_name'], 'string', 'max' => 40],
//            [['country'], 'string', 'max' => 30],
//            [['file_name','upload_name'], 'string', 'max' => 100],
//            ['file_name', 'file', 'extensions' => ['pdf'], 'maxSize' => 1024*1024*2],
//            [['file_name'], 'unique'],
//            [['city','postcode'],'required'],
//        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'document_name' => 'Название документа',
            'country' => 'Страна',
            'file_name' => 'Файл',
            'time_create_request' => 'Дата создания',
            'client_id' => 'Client ID',
            'notary_id' => 'Нотариус',
            'status' => 'Статус',
        ];
    }
    
   public static function deleteFile($file_name){
       $path=Yii::getAlias('@uploadNotary').'/'.$file_name[0].'/'.$file_name;
        if(file_exists($path) && unlink($path)){
            return true;
        }
        return false;
   }
   public static function getStatus($id){
       return self::findOne(['id'=>$id])->status;
   }
   public static function getNotaryId($id){
       return self::findOne(['id'=>$id])->notary_id;
   }
   public static function getNotary($id){
        return self::findOne(['id'=>$id]);
   }
   public  function upload($file_obj){
           $file_name=md5($file_obj->baseName.rand(1,99).time()).'.'.$file_obj->extension;
           if(!file_exists(Yii::getAlias('@uploadNotary').'/'.$file_name[0]))
           mkdir(Yii::getAlias('@uploadNotary').'/'.$file_name[0],0777, true);
           $file_obj->saveAs(Yii::getAlias('@uploadNotary').'/'.$file_name[0].'/'.$file_name);
           return $file_name;
   } 
}
