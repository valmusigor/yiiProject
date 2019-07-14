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
        return [
            [['time_create_request', 'client_id', 'notary_id', 'status'], 'integer'],
            [['document_name'], 'string', 'max' => 40],
            [['country'], 'string', 'max' => 30],
            [['file_name','upload_name'], 'string', 'max' => 100],
            ['file_name', 'file', 'extensions' => ['pdf'], 'maxSize' => 1024*1024*2],
            [['file_name'], 'unique'],
        ];
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
}
