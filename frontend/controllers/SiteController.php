<?php

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\User;
use yii\helpers\Url;
use Yii;
/**
 * @author igor
 */
class SiteController extends Controller {
    public function actionIndex(){
        if(Yii::$app->user->isGuest){
          return $this->redirect( Url::to(['user/login'])."?error=Вы+не+авторизованы"); 
        }
        return $this->render('index',['login'=>Yii::$app->user->identity->username]);
  }
}
