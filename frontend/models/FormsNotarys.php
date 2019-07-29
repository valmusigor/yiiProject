<?php

namespace frontend\models;
use frontend\models\Notary;
use frontend\models\Form;
use Yii;

/**
 * This is the model class for table "forms_notarys".
 *
 * @property int $id
 * @property int $forms_id
 * @property int $notary_id
 * @property string $result_string
 *
 * @property Forms $forms
 * @property Notary $notary
 */
class FormsNotarys extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forms_notarys';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['forms_id', 'notary_id'], 'required'],
            [['forms_id', 'notary_id'], 'integer'],
            [['result_string'], 'string', 'max' => 255],
            [['forms_id'], 'exist', 'skipOnError' => true, 'targetClass' => Form::className(), 'targetAttribute' => ['forms_id' => 'id']],
            [['notary_id'], 'exist', 'skipOnError' => true, 'targetClass' => Notary::className(), 'targetAttribute' => ['notary_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'forms_id' => 'Forms ID',
            'notary_id' => 'Notary ID',
            'result_string' => 'Result String',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForms()
    {
        return $this->hasOne(Form::className(), ['id' => 'forms_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotary()
    {
        return $this->hasOne(Notary::className(), ['id' => 'notary_id']);
    }
}
