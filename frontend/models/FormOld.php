<?php

namespace frontend\models;
use Yii;

/**
 * This is the model class for table "forms".
 *
 * @property int $id
 * @property string $form_name
 * @property string $field_name
 * @property int $type_field
 * @property int $required
 * @property int $uniquie
 * @property int $type_value
 * @property int $size
 * @property string $for_table
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
            [['form_name', 'field_name', 'type_field', 'for_table'], 'required'],
            [['required', 'uniquie', 'size', 'file_size'], 'integer'],
            [['form_name', 'field_name', 'type_field', 'type_value', 'for_table'], 'string', 'max' => 100],
            [['extensions'], 'string', 'max' => 45],
            [['form_name', 'field_name', 'type_field', 'type_value', 'for_table'], 'match', 'pattern' => '/^[0-9a-zA-Z_\-\s]+$/i',
                'message'=>'Некорректный ввод'],
            ['field_name','checkExist'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_name' => 'Название формы',
            'field_name' => 'Имя поля',
            'type_field' => 'Тип поля',
            'required' => 'Обязательное',
            'uniquie' => 'Уникальное',
            'type_value' => 'Type Value',
            'size' => 'Size',
            'for_table' => 'For Table',
            'extensions'=>'Расширение',
            'file_size' => 'Размер файла',
        ];
    }
    public function checkExist($attribute,$params){
       $field= self::find()->andWhere(['field_name'=>$this->field_name])->andWhere(['form_name'=>$this->form_name])->all();
       if($field)
       {
           $this->addError($attribute, 'Поле существует');
           return false;
       }
       return true;
    }
}
