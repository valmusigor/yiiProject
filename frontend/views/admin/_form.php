 <?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Forms */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="forms-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'form_name')->dropDownList($name_forms) ?>

    <?= $form->field($model, 'field_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_field')->dropDownList(['textInput' => 'Текстовое поле', 'fileInput' => 'Загрузка файла']); ?>

    <?= $form->field($model, 'required')->dropDownList([1 => 'Да', 2 => 'Нет']); ?>

    <?= $form->field($model, 'uniquie')->dropDownList([2 => 'Нет',1 => 'Да' ]); ?>

    <?= $form->field($model, 'type_value')->dropDownList(['varchar' => 'Строка','int' => 'число']); ?>

    <?= $form->field($model, 'size')->textInput() ?>

    <?= $form->field($model, 'for_table')->dropDownList($name_tables) ?>
    
     <?= $form->field($model, 'extensions')->dropDownList(['no' => 'Не требуется','pdf' => 'pdf','jpg'=>'jpg','jpeg'=>'jpeg']); ?>
    
     <?= $form->field($model, 'file_size')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
