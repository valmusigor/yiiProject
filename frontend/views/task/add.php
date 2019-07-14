<?php 
use yii\helpers\{Url,Html};
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
?>
<?php $form= ActiveForm::begin(['id'=>'addTask']) ?>
  
<?=$form->field($model, 'text')->textInput(['placeholder' => 'enter task'])->label('Task');?>
  
<?=$form->field($model, 'time_end')->widget(DateTimePicker::className(),[
    'name' => 'time_end',
    'type' => DateTimePicker::TYPE_INPUT,
    'options' => ['placeholder' => 'Select time & date...'],
    'convertFormat' => true,
    'value'=> date("d.m.Y h:i",(integer) $model->time_end),
    'pluginOptions' => [
        'format' => 'dd.MM.yyyy hh:i',
        'autoclose'=>true,
        'weekStart'=>1, //неделя начинается с понедельника
        'startDate' => '01.05.2015 00:00', //самая ранняя возможная дата
        'todayBtn'=>true, //снизу кнопка "сегодня"
    ]
]);?>
 <?=Html::submitButton('Add', ['class'=>'btn btn-primary'])?>
<? ActiveForm::end(); ?>

