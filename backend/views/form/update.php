<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Forms */

$this->title = 'Update Forms: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="forms-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'name_forms'=>$name_forms,'name_tables'=>$name_tables,
    ]) ?>

</div>

