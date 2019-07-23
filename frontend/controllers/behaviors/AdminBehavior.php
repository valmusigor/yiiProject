<?php

namespace frontend\controllers\behaviors;
use frontend\controllers\behaviors\AccessBehavior;
use yii\web\Controller;
use Yii;
/**
 * Description of AccessBehavior
 *
 * @author igor
 */
class AdminBehavior extends AccessBehavior{
    public function events() {
        return [
        Controller::EVENT_BEFORE_ACTION=>'checkAdminAccess',
        ];
    }

    public function checkAdminAccess(){
        $this->checkAccess();
         if(Yii::$app->user->identity->role!==3){
          //return Yii::$app->controller->redirect( ['user/login']); 
          header('Location:/site/index');
          exit();
        }
    }
}
