<?php
use frontend\assets\CommonAsset;
CommonAsset::register($this);
//$this->registerJsFile('/js/task/script.js');
?>
<div style="display:flex;justify-content:space-between;font-size:30px">
  <div class="wrap">
        <div class="menu" ><a class="item" href="/task">task list</a></div>
        <div class="menu" ><a class="item" href="cabinet/file/">file heap</a></div>
  </div> 
  <div><strong style="vertical-align:top"><?=(isset($login))?$login:''?></strong><a href="/logout"><i class="fas fa-sign-out-alt fa-lg"></i></a></div>
</div>

