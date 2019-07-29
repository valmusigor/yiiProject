<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "nfiles".
 *
 * @property int $id
 * @property string $file_name
 * @property string $upload_name
 * @property int $order_id
 * @property int $user_id
 *
 * @property Notary $order
 * @property User $user
 */
class Nfiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nfiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id'], 'required'],
            [['order_id', 'user_id'], 'integer'],
            [['file_name'], 'string', 'max' => 50],
            [['upload_name'], 'string', 'max' => 100],
            [['file_name'], 'unique'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Notary::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_name' => 'File Name',
            'upload_name' => 'Upload Name',
            'order_id' => 'Order ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Notary::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
   public  function upload($file_obj){
           $file_name=md5($file_obj->baseName.rand(1,99).time()).'.'.$file_obj->extension;
           if(!file_exists(Yii::getAlias('@uploadNotary').'/'.$file_name[0]))
           mkdir(Yii::getAlias('@uploadNotary').'/'.$file_name[0],0777, true);
           $file_obj->saveAs(Yii::getAlias('@uploadNotary').'/'.$file_name[0].'/'.$file_name);
           return $file_name;
   } 
   
   public  function deleteFile(){
       $path=Yii::getAlias('@uploadNotary').'/'.$this->file_name[0].'/'.$this->file_name;
        if(file_exists($path) && unlink($path)){
            return true;
        }
        return false;
   }
}
