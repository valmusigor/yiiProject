<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language'=>'ru',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/login'=>'user/login',
                '/logout'=>'user/logout',
                '/register'=>'user/register',
                '/auth'=>'user/auth',
                '/auth/add'=>'user/add',
                'task/delete/<deleteId:\d+>' => 'task/delete',
                [
                'pattern' => 'task/<sort:(up|down){0,1}>',
                'route' => 'task/index',
                'defaults' => ['sort' => ''],
                ],
                '/'=>'site/index',
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class'=>'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'xraymoby@gmail.com',
                'password' => 'jylutznvobphlmmf',
                'port' => '587',
                'encryption' => 'tls'
            ],
        ],
//        'assetManager'=>[
//            'bundles'=>[
//                'yii\web\JqueryAsset'=>[
//                    'js'=>[]
//                ],
//                'yii\web\YiiAsset'=>[
//                    'js'=>[]
//                ],
//                'yii\bootstrap\BootstrapPluginAsset'=>[
//                    'js'=>[]
//                ],
//            ],
//        ],отключение автоматического подтягивания ассетов пакетов таких как к примеру jquerry
        
    ],
    'params' => $params,
];
