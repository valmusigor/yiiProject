<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?=Html::tag('div', Html::encode(Yii::$app->request->get('error')));?>
<div style="display:flex;justify-content:space-between">
    <?php 
    $form= ActiveForm::begin([
        'id'=>'fileUploadForm',
        'method'=>'POST',
        'action'=>'/file/upload',
        'options'=>['enctype'=>'multipart/form-data'],]); ?>
     <?=$form->field($model, 'name')->fileInput();?>
     <?=Html::submitButton('UPLOAD', ['class'=>'btn btn-primary']); ?>
     <? ActiveForm::end(); ?>
        <span><strong style="font-size:30px"><span class="logo"><a  href="/"  title="на главную"><?=(isset($result['login']))?$result['login']:''?></a></span></strong><a href="/logout"><i class="fas fa-sign-out-alt fa-2x"></i></a></span>
     <?=$this->render('fileList',['files'=>$files]); ?>
</div>

