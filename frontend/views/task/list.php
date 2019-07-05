<?php
 foreach($tasks as $task):
?>
        <div style="margin-top:10px" class=<?=($task->time_end<strtotime(date("H:i Y-m-d")))?'expired':'' ?>>
          <span class="des"><?=$task->text.'|'.date("H:i Y-m-d",$task->time_end) ?></span>
          <i class="fas fa-edit fa-lg editTask" id=<?=$task->taskId?>></i>
          <a href="/task/delete/<?=$task->taskId?>">
            <i class="fa fa-trash-alt fa-lg"></i>
          </a>
        </div>
<?php
      endforeach;
      ?>

