<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property string $text_message
 * @property int $time_create
 * @property int $sender_id
 * @property int $notary_request_id
 * @property int $status
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time_create', 'sender_id', 'notary_request_id', 'status'], 'integer'],
            [['text_message'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text_message' => 'Text Message',
            'time_create' => 'Time Create',
            'sender_id' => 'Sender ID',
            'notary_request_id' => 'Notary Request ID',
            'status' => 'Status',
        ];
    }
    public static function getMessagesByNotary($notary_request_id){
        return self::find()->where(['notary_request_id'=>$notary_request_id])->all();
    }
}
