<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\User;
/* @var $this yii\web\View */
/* @var $model frontend\models\Notary */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Notaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="notary-view">
    <? if(Yii::$app->user->identity->role!==2 && $model->status===1): ?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <? endif; ?>
   <?php 
   $atr=[
            'time_create_request:datetime',
       ];
   $count=0;
       foreach ($model->formsNotarys as $con) {
           if($con->forms->type_field!=='fileInput')
           $atr[]=[
               'attribute'=>$con->forms->field_name,
               'value'=>$con->result_string,
           ];
           else if(($model_user=User::findOne ($model->nfiles[$count]->user_id)) && $model_user->role===1){
           $atr[]=[ 
               'attribute' => $con->forms->field_name,
                'format' => 'raw',
                'label'=>'Файл клиента',
                'value' => function ($data) use ($count){
                    return \yii\helpers\Html::tag(
                        'a',
                        $data->nfiles[$count]->upload_name,
                        [
                            'href' => Yii::getAlias('@showNotary').'/'.$data->nfiles[$count]->file_name[0].'/'.$data->nfiles[$count]->file_name,
                        ]
                    );
                },
            ];
            $count++;
           }
           else {
            $count++;
            continue;
           }
       }
   $atr[]= [ 
               'attribute' => 'notary_id',
                'format' => 'raw',
                'value' => function ($data) {
                    $notary_id = $data->notary_id;
                    return \yii\helpers\Html::tag(
                        'span',
                        ($notary_id!==NULL)?User::findOne(['id'=>$notary_id])->username:'Ожидание исполнителя'
                    );
                },
            ];
            foreach ($model->nfiles as $nfile)   
            {
                if(($model_user=User::findOne ($nfile->user_id)) && $model_user->role===2)
                {
                    $atr[]=[ 
               'attribute' => $nfile->file_name,
                'format' => 'raw',
                'label'=>'Файл нотариуса',
                'value' => function ($data) use ($nfile){
                    return \yii\helpers\Html::tag(
                        'a',
                        $nfile->upload_name,
                        [
                            'href' => Yii::getAlias('@showNotary').'/'.$nfile->file_name[0].'/'.$nfile->file_name,
                        ]
                    );
                },
            ];
                }
            }   
                
                
    $atr[]= [ 
               'attribute' => 'status',
               'format' => 'raw',
                'value' => function ($data) {
                    $status = $data->status;
                    return \yii\helpers\Html::tag(
                        'span',
                        (($status===1) ? 'Принят' : (($status===2)? 'В работе':'Завершен') ),
                        [
                            'class' => 'label label-' . (($status===3) ? 'success' : 'danger'),
                        ]
                    );
                },
            ];             
   ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $atr,
    ]) ?>

</div>