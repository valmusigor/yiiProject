<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class Task extends ActiveRecord{
   public static function tableName() {
        return '{{task}}';
    }
    public function rules() {
        return [
        [['text'], 'trim'],
        ['time_end', 'compare', 
            'compareValue' => strtotime(date("H:i Y-m-d")),
            'operator' => '>', 
            'type' => 'number',
            'message' => 'Выберите корректную дату',
        ],
//        ['time_end',
//          'unique',
//          'message' => 'В данное время запланирована задача',
//        ],
        [['text'], 'required'],    
    ];
   }
   public static function getTasks($id,$sort){
       return (($sort==='up')?Task::find()->where(['userId'=>$id])
               ->orderBy(['time_end'=>SORT_ASC])->all()
               :Task::find()->where(['userId'=>$id])->orderBy(['time_end'=>SORT_DESC])->all()); 
        
   }
   public static function getTaskByDate($id,$time_end){
       return Task::find()->where(['userId'=>$id,'time_end'=>$time_end])->all();       
   }
}


