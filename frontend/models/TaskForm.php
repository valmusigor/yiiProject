<?php

namespace frontend\models;
use yii\base\Model;
use frontend\models\Task;
use Yii;
/**
 * Description of TaskForm
 *
 * @author igor
 */
class TaskForm extends Model{
    public $text;
    public $time_end;
    public function rules() {
       return [
        [['text'], 'trim'],
        ['time_end','checkRightData'
        ],
        ['time_end',
          'checkUnique',
        ],
        [['text'], 'required'],    
    ];
    }
    public function save(){
        if($this->validate()){
            $task= new Task();
            $task->text=$this->text;
            $task->time_end= strtotime($this->time_end);
            $task->time_create=time();
            $task->userId=Yii::$app->user->identity->id;
            $task->save();
            return true;
        }
        return false;
    }
    public function checkUnique($attribute,$params){
       if(Task::getTaskByDate(Yii::$app->user->identity->id, strtotime($this->time_end)))
       {
           $this->addError($attribute, 'В данное время запаланирована задача');
           return false;
       }
       return true;
    }
    public function checkRightData($attribute,$params){
       if(strtotime($this->time_end)<strtotime(date("d-m-Y H:i",time())))
       {
           $this->addError($attribute, 'Некорректно задано время');
           return false;
       }
       return true;
    }
}
