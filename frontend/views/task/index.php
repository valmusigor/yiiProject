<?php 
use yii\helpers\Url;
use frontend\assets\CommonAsset;
CommonAsset::register($this);
?>  
    <div style="color:red"><?=$error?></div>
    <div style="display:flex;justify-content:space-between">
      <?=$this->render('add',['model'=>$model]);?>
      <span>
        <strong style="font-size:30px">
          <span class="logo">
            <a  href="<?=Url::to(['site/index']);?>" title="на главную"><?=$login?></a>
          </span>
        </strong>
          <a href="<?=Url::to(['user/logout']);?>">
             <i class="fas fa-sign-out-alt fa-2x"></i>
          </a>
      </span>
    </div>
    <span>Сортировка по дате</span>
    <a href="<?=Url::to(['task/index']).'/up';?>">По возрастанию</a> 
    <a href="<?=Url::to(['task/index']).'/down';?>">По убыванию</a> 
    <form action="/task/update">
      <?=$this->render('list',['tasks'=>$tasks]); ?>
    </form>
    <?php $this->registerJsFile('/js/createTaskEdit.js'); ?>

