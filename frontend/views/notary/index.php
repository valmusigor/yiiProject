<?php
/* @var $this yii\web\View */
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;
use frontend\models\User;
use frontend\assets\CommonAsset;
CommonAsset::register($this);
echo GridView::widget(
    [
        /**
         * Экземпляр класса, который реализует \yii\data\DataProviderInterface. В нашем случае ActiveDataProvider
         */
        'dataProvider' => $dataProvider,
        /**
         * Модель которая используется для фильтрации. Она нужна для отображения input-ов поиска в шапке таблицы
         */
//        'filterModel' => new \app\models\Page(),
        /**
         * Список колонок которые необходимо отобразить
         */
        'columns' => [
            /**
             * Столбец нумерации. Отображает порядковый номер строки
             */
            [
                'class' => \yii\grid\SerialColumn::class,
            ],
            /**
             * Перечисленные ниже поля модели отображаются как колонки с данными без изменения
             */
            'document_name',
            'country',
            [ 
               'attribute' => 'file_name',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    $status = $model->{$column->attribute};
                    return \yii\helpers\Html::tag(
                        'a',
                        $model->upload_name,
                        [
                            'href' => Yii::getAlias('@showNotary').'/'.$model->file_name[0].'/'.$model->file_name,
                        ]
                    );
                },
            ],
                           /**
             * Пример краткого описания настроек столбца.
             * Данный способ описания имеет следующий вид attribute_name:output_format:attribute_label.
             */
//           'time_create_request:datetime:Crete datetime',
//            /**
//             * Пример использования форматера
//             */
            [
                /**
                 * Имя аттрибута модели
                 */
                'attribute' => 'time_create_request',
                /**
                 * Формат вывода
                 */
                'format' => ['datetime', 'php:h:i:s d-m-Y'],
            ],
            /**
             * Произвольная колонка с определенной логикой отображения и фильтром в виде выпадающего списка
             */
            [ 
               'attribute' => 'status',//Название поля модели
                /**
                 * Формат вывода.
                 * В этом случае мы отображает данные, как передали.
                 * По умолчанию все данные прогоняются через Html::encode()
                 */
                'format' => 'raw',
                /**
                 * Переопределяем отображение фильтра.
                 * Задаем выпадающий список с заданными значениями вместо поля для ввода
                 */
                'filter' => [
                    1 => 'Принят',
                    2 => 'В работе',
                    3 => 'Завершен'
                ],
                /**
                 * Переопределяем отображение самих данных.
                 * Вместо 2, 1 или 0 выводим Принят, В работе, Завершен соответственно.
                 * Попутно оборачиваем результат в span с нужным классом
                 */
                'value' => function ($model, $key, $index, $column) {
                    $status = $model->{$column->attribute};
                    return \yii\helpers\Html::tag(
                        'span',
                        (($status===1) ? 'Принят' : (($status===2)? 'В работе':'Завершен') ),
                        [
                            'class' => 'label label-' . (($status===3) ? 'success' : 'danger'),
                        ]
                    );
                },
            ],
            [ 
               'attribute' => 'notary_id',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    $notary_id = $model->{$column->attribute};
                    return \yii\helpers\Html::tag(
                        'span',
                        ($notary_id!==NULL)?User::findOne(['id'=>$notary_id])->username:'Ожидание исполнителя'
                    );
                },
            ],
                        
         
            /**
             * Колонка кнопок действий
             */
            [
                /**
                 * Указываем класс колонки
                 */
                'class' => \yii\grid\ActionColumn::class,
                /**
                 * Определяем набор кнопочек. По умолчанию {view} {update} {delete}
                 */
                'template' => '{subscribe} {cancel} {update} {delete} {repeat} {message}',
                 'buttons'=>[
                     'subscribe' => function ($url,$model,$key) {
                            return Html::a('Подписать', $url, ['class' => 'btn btn-success btn-xs']);
                        },         
                        'cancel' => function ($url,$model,$key) {
                            return Html::a('Отменить подпись', $url, ['class' => 'btn btn-danger btn-xs']);
                        },
                        'repeat' => function ($url,$model,$key) {
                            return Html::a('Вернутся к подписи', $url, ['class' => 'btn btn-success btn-xs']);
                        },
                        'message' => function ($url,$model,$key) {
                            return Html::a(Html::tag('i','',['class' => 'far fa-comment-dots fa-lg messageIcon']), $url, ['class' => 'btn btn-primary btn-xs','class'=>'openMessage']);
                        },
                       
                 ],
                'visibleButtons'=>[
                    'update'=>function ($model, $key, $index) { return ($model->status === 1 && Yii::$app->user->identity->role===1); } ,
                    'delete'=>function ($model, $key, $index) { return ($model->status === 1 && Yii::$app->user->identity->role===1); } ,
                    'subscribe'=>function ($model, $key, $index) { return ($model->status === 1 && Yii::$app->user->identity->role===2);} ,
                    'cancel'=>function ($model, $key, $index) { return ($model->status === 2 && Yii::$app->user->identity->role===2 && $model->notary_id===Yii::$app->user->identity->id);},
                    'repeat'=>function ($model, $key, $index) { return ($model->status === 2 && Yii::$app->user->identity->role===2 && $model->notary_id===Yii::$app->user->identity->id);},
                    'message'=>'true',
                ],    
            ],             
        ],
    ]
);
?>

<div class="row">
    <div class="col-md-5">
        <?php if(Yii::$app->user->identity->role===1): ?>
  <?php 
    $form= ActiveForm::begin([
        'id'=>'addRequest',
      //  'method'=>'POST',
        'options'=>['enctype'=>'multipart/form-data'],]); ?>
  
<?=$form->field($model, 'document_name')->textInput(['placeholder' => 'enter document name'])->label('Document name');?>
<?=$form->field($model, 'country')->textInput(['placeholder' => 'enter country'])->label('Country');?>
<?=$form->field($model, 'file_name')->fileInput();?>  
<div class="row">
    <div class="col-md-6">
 <?=Html::submitButton('Добавить', ['class'=>'btn btn-primary'])?>
        <?=Html::tag('a','Очистить',['href'=> Url::to(['notary/index']),'class'=>'btn btn-primary'])?>
    </div>
</div>
<? ActiveForm::end(); ?>
 <?php endif; ?>
    </div>
    <div class="col-md-5" id="chat-form">
        <h2>Чат</h2>
        <div id="messageDesk"  data-spy="scroll"  data-offset="0">
        
        </div>
       
         <?php $form_message= ActiveForm::begin([ 'id'=>'addMessage',]); ?>
         <?=$form_message->field($modelMessageForm, 'text_message')->textInput(['placeholder' => 'введите текст сообщения','id'=>'messageInput']);?>
         <?= $form_message->field($modelMessageForm, 'notary_request_id')->hiddenInput(['id'=>'notary_request_id'])->label(false);?>
         <?=Html::button('Отправить', ['class'=>'btn btn-primary','id'=>'sendMessage'])?>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$this->registerJsFile('/js/message.js');
?>
