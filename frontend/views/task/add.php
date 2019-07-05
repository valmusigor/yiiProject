<?php use yii\helpers\Url;?>
<form action="<?=Url::to(['task/save']);?>" class="addTask">
  <input type="text" name="task" placeholder="enter task">
  <select name="hour">
    <?php for($i=0;$i<24;$i++): ?>
      <option value=<?=($i<10)?'0'.$i:$i ?>><?=($i<10)?'0'.$i:$i ?></option>
    <?php endfor;?>
  </select>
  <select name="minutes">
    <? for($i=0;$i<60;$i++): ?>
      <option value=<?=($i<10)?'0'.$i:$i ?>><?=($i<10)?'0'.$i:$i ?></option>
    <? endfor;?>
  </select>
  <input type="date" name="calendar" value=<?=date("Y-m-d")?> min=<?=date("Y-m-d")?>>
  <button type="submit">Add task</button>
</form>

