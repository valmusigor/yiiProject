<?php

namespace frontend\controllers\behaviors;
use yii\base\Behavior;
use yii\web\Controller;
use Yii;
/**
 * Description of AccessBehavior
 *
 * @author igor
 */
class AccessBehavior extends Behavior{
    public function events() {
        return [
        Controller::EVENT_BEFORE_ACTION=>'checkAccess',
        ];
    }

    public function checkAccess(){
         if(Yii::$app->user->isGuest){
          //return Yii::$app->controller->redirect( ['user/login']); 
          header('Location:/login?error=Вы+неавторизированы');
          exit();
        }
    }
}
