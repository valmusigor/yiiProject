<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class Task extends ActiveRecord{
   public static function tableName() {
        return '{{task}}';
    }
}

