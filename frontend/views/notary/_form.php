<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Notary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notary-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php foreach($form_field as $field): ?>
        <?= call_user_func_array(array($form->field($model, $field->field_name),$field->type_field),array())->label($field->field_name);?>
    <?php endforeach;?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>