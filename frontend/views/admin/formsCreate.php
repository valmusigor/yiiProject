<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Forms */

$this->title = 'Create Forms';
$this->params['breadcrumbs'][] = ['label' => 'Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forms-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'name_forms'=>$name_forms,'name_tables'=>$name_tables,
    ]) ?>

</div>

