<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;
use frontend\models\User;
?>
<div class="row">
    <div class="col-md-5">
        <div><?=$notary->document_name?></div>
        <div><?=$notary->country?></div>
        <div>
            <a href =<?=Yii::getAlias('@showNotary').'/'.$notary->file_name[0].'/'.$notary->file_name?>>
            <?=$notary->upload_name?>
            </a>
        </div>
        <pre><?= print_r($notary)?></pre>
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
