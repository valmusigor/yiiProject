<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-md-5">
       <?=$this->render('view',['model'=>$notary]);?>
    </div>
    <div class="col-md-5">
  <?php 
    $form= ActiveForm::begin([
        'id'=>'subscribeForm',
        'options'=>['enctype'=>'multipart/form-data'],]); ?>

<?=$form->field($model, 'file_name')->fileInput();?>  

 <?=Html::submitButton('Загрузить подписанный', ['class'=>'btn btn-primary'])?>
    
<? ActiveForm::end(); ?>
 
    </div>
</div>
