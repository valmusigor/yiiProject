<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<span style="color:red"><?=Yii::$app->request->get('error')?></span>
<div class="row">
    <div class="col-md-5">
      <?php $form = ActiveForm::begin(['id'=>'login_form','options'=>['method'=>'POST']]);?>
        <?=$form->field($model, 'username')->textInput(['placeholder' => 'enter login'])->label('Login');?>
        <?=$form->field($model, 'pass')->passwordInput(['placeholder' => 'enter password'])->label('Password');?>
        <?=Html::submitButton('Signup', ['class'=>'btn btn-primary']);?>
      <?php ActiveForm::end(); ?> 
    </div>
</div>
<a href="/register">Зарегистироваться</a> 
