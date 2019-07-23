<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class MessageForm extends Model
{
    public $text_message;
    public $notary_request_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text_message','notary_request_id'], 'required'],
            ['text_message', 'string','max'=>99],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'text_message' => 'Текст сообщения',
        ];
    }
}
