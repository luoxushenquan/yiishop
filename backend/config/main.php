<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'language'=>'zh-CN',
    'bootstrap' => ['log'],
    'modules' => [],
    'defaultRoute' => 'login/login',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            //实现类自己登录配置的模型
            'loginUrl'=>['login/login'],
            'identityClass' => 'backend\models\User',
            //开启自动登录功能默认配置好的
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        //地址美化
        'urlManager' => [
            'enablePrettyUrl' => true,//梅花地址
            'showScriptName' => false,//脚本文件
            // 'suffix'=>'.html',//伪静态后缀
            'rules' => [
            ],
        ],

    ],
    'params' => $params,
];
