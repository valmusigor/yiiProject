<?php

namespace frontend\controllers;
use frontend\models\Form;
use frontend\controllers\behaviors\AdminBehavior;
use yii\data\ActiveDataProvider;
use Yii;
use yii\db\QueryBuilder;

class AdminController extends \yii\web\Controller
{
    public function behaviors() {
        return [
        AdminBehavior::className(),
    ];     
    }
    public function actionIndex()
    {
         return $this->render('index');
    }
    public function actionForms()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Form::find(),
        ]);

        return $this->render('forms', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionFormsview($id)
    {
        return $this->render('formsView', [
            'model' => $this->findModel($id),
        ]);
    }
    protected function findModel($id)
    {
        if (($model = Form::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionFormscreate()
    {
        $model = new Form();
        //получаем данные имеющихся форм для формирования dropDownList
        $results=Form::find()->select('form_name')->groupBy('form_name')->asArray()->all();
        foreach ($results as $value)
        {
        $name_forms[$value['form_name']]=$value['form_name'];
        }
        //получаем данные имеющихся таблиц для формирования dropDownList
        $results=Form::find()->select('for_table')->groupBy('for_table')->asArray()->all();
        foreach ($results as $value)
        {
        $name_tables[$value['for_table']]=$value['for_table'];
        }
        if ($model->load(Yii::$app->request->post()) &&  $model->validate())
        {
            if($model->type_value==='varchar' && (intval($model->size)>255 || $model->size===''))
              $model->size=255;
            if($model->save()){
                return $this->redirect(['/admin/formsview', 'id' => $model->id]);
            }
        }
        return $this->render('formsCreate', [
            'model' => $model,'name_forms'=>$name_forms,'name_tables'=>$name_tables,
        ]);
    }
    public function actionFormsdelete($id)
    {
        if($id>3 && $model=$this->findModel($id))
        {
          
         if($model->formsNotarys)
         {
             $model->todelete=1;
             if($model->save()){
             Yii::$app->session->setFlash('success', 'Success marked for deletion');
             }
         }
         else if($model->delete() )
             Yii::$app->session->setFlash('success', 'Success delete field');
        }
        else Yii::$app->session->setFlash('error', 'Access denied');
        return $this->redirect(['/admin/forms']);
    }
    public function actionFormsupdate($id)
    {
        if($id>3){
        $model = $this->findModel($id);
         $results=Form::find()->select('form_name')->groupBy('form_name')->asArray()->all();
        foreach ($results as $value)
        {
        $name_forms[$value['form_name']]=$value['form_name'];
        }
        $results=Form::find()->select('for_table')->groupBy('for_table')->asArray()->all();
        foreach ($results as $value)
        {
        $name_tables[$value['for_table']]=$value['for_table'];
        }
        if ($model->load(Yii::$app->request->post()) &&  $model->validate()){
            $old_model=$this->findModel($id);
           // Yii::$app->db->createCommand()->dropColumn($old_model->for_table,$old_model->field_name)->execute();
            if($model->type_value==='varchar' && (intval($model->size)>255 || $model->size===''))
              $model->size=255;
           // Yii::$app->db->createCommand()->addColumn($model->for_table,$model->field_name,$model->type_value.'('.$model->size.')')->execute();
            if ($model->save()) {
            return $this->redirect(['/admin/formsview', 'id' => $model->id]);
        }
        }
        return $this->render('formsUpdate', [
            'model' => $model,'name_forms'=>$name_forms,'name_tables'=>$name_tables,
        ]);
        }
        Yii::$app->session->setFlash('error', 'Access denied');
        return $this->redirect(['/admin/forms']);
    }

}
