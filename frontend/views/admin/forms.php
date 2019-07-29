<?php

use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Forms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forms-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Forms', ['admin/formscreate'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'form_name',
            'field_name',
            [
              'attribute' =>'type_field',
               'format' => 'raw',
               'value' => function ($model, $key, $index, $column) {
                    $type_field = $model->{$column->attribute};
                    switch ($type_field){
                        case 'textInput':return \yii\helpers\Html::tag('span','Текстовое');
                        case 'fileInput':return \yii\helpers\Html::tag('span','Файловое');
                        default : return \yii\helpers\Html::tag('span','Неопределено');
                    }
                    
                },
                
            ],
            [
              'attribute' =>'required',
                'format' => 'raw',
               'value' => function ($model, $key, $index, $column) {
                    $required = $model->{$column->attribute};
                    return \yii\helpers\Html::tag('span',(($required===1) ? 'Да' :'Нет'  ),
                        [
                            'class' => 'label label-' . (($required===1) ? 'success' : 'danger'),
                        ]
                    );
                },
                
            ],
            [
              'attribute' =>'uniquie',
                'format' => 'raw',
               'value' => function ($model, $key, $index, $column) {
                    $uniquie = $model->{$column->attribute};
                    return \yii\helpers\Html::tag('span',(($uniquie===1) ? 'Да' :'Нет'  ),
                        [
                            'class' => 'label label-' . (($uniquie===1) ? 'success' : 'danger'),
                        ]
                    );
                },
                
            ],
            [
              'attribute' =>'extensions',
               'format' => 'raw',
               'value' => function ($model, $key, $index, $column) {
                    $extensions = $model->{$column->attribute};
                    return \yii\helpers\Html::tag('span',((!$extensions) ? 'Не используется' :$extensions  )
                    );
                },
                
            ],
            'type_value',
            'size',
            [
              'attribute' =>'todelete',
               'format' => 'raw',
               'value' => function ($model, $key, $index, $column) {
                    $todelete = $model->{$column->attribute};
                    return \yii\helpers\Html::tag('span',(($todelete===1) ? 'Да' :'Нет'  ),
                        [
                            'class' => 'label label-' . (($todelete===1) ? 'danger' : 'success'),
                        ]
                    );
                },
                
            ],            
            //'uniquie',
            //'type_value',
            //'size',
            //'for_table',

            ['class' => 'yii\grid\ActionColumn',
             'buttons' => [
             'view' => function ($url, $model, $key) {
                 return Html::a('', ['/admin/formsview', 'id' => $key] ,['class' => 'glyphicon glyphicon-eye-open']);
              },
             'delete' => function ($url, $model, $key) {
                 return Html::a('', ['/admin/formsdelete', 'id' => $key] ,['class' => 'glyphicon glyphicon-trash']);
              },   
              'update' => function ($url, $model, $key) {
                 return Html::a('', ['/admin/formsupdate', 'id' => $key] ,['class' => 'glyphicon glyphicon-pencil']);
              }, 
            ],
            ],
        ],
    ]); ?>


</div>

