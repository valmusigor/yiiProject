<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<span style="color:red"><?=Yii::$app->request->get('error')?></span>
<div class="row">
    <div class="col-md-5">
      <?php $form = ActiveForm::begin(['id'=>'register_form','options'=>['method'=>'POST']]);?>
        <?=$form->field($model, 'username')->textInput(['placeholder' => 'enter login'])->label('Login');?>
        <?=$form->field($model, 'pass')->passwordInput(['placeholder' => 'enter password'])->label('Password');?>
        <?=$form->field($model, 'email')->input('email',['placeholder' => 'enter email'])->label('Email');?>
        <?=$form->field($model, 'role')->dropDownList([
        '1' => 'Клиент',
        '2'=>'Нотариус'
        ],['id' => 'registerRole',
        'options' => [
            '1' => ['Selected' => true]
        ]]);?>
        <?=Html::submitButton('Signup', ['class'=>'btn btn-primary']);?>
      <?php ActiveForm::end(); ?> 
    </div>
</div>
<a href="/login">Войти</a>
       