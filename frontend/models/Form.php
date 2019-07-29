<?php

namespace frontend\models;
use frontend\models\FormsNotarys;
use frontend\models\Notary;
use Yii;

/**
 * This is the model class for table "forms".
 *
 * @property int $id
 * @property string $form_name
 * @property string $field_name
 * @property string $type_field
 * @property int $required
 * @property int $uniquie
 * @property string $type_value
 * @property int $size
 * @property string $for_table
 * @property string $extensions
 * @property int $file_size
 *
 * @property FormsNotarys[] $formsNotarys
 */
class Form extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['form_name', 'field_name', 'type_field', 'type_value', 'for_table'], 'required'],
            [['required', 'uniquie', 'size', 'file_size','todelete'], 'integer'],
            [['form_name', 'field_name', 'type_field', 'type_value', 'for_table'], 'string', 'max' => 100],
            [['extensions'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_name' => 'Form Name',
            'field_name' => 'Field Name',
            'type_field' => 'Type Field',
            'required' => 'Required',
            'uniquie' => 'Uniquie',
            'type_value' => 'Type Value',
            'size' => 'Size',
            'for_table' => 'For Table',
            'extensions' => 'Extensions',
            'file_size' => 'File Size',
            'todelete' => 'На удаление',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormsNotarys()
    {
        return $this->hasMany(FormsNotarys::className(), ['forms_id' => 'id']);
    }
    
     public function getNotarys()
    {
        return $this->hasMany(Notary::className(), ['id' => 'notary_id'])
            ->viaTable('forms_notarys',['forms_id' => 'id']);
    }
}
