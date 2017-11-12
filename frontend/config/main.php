<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'language'=>'zh-CN',

    //布局文件设置（false表示关闭）
//    'layout'=>'mine',
    'layout'=>false,
    //默认路由
  'defaultRoute' => 'member/login',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            //制定实现认证接口
            'class'=>'yii\web\user',
            'identityClass' => 'frontend\models\admin',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            //默认登陆页面
            'loginUrl'=>['admin/login']
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
//地址美化
        'urlManager' => [
            'enablePrettyUrl' => true,//启用美化地址
            'showScriptName' => false,//是否显示脚本文件
            // 'suffix'=>'.html',//伪静态后缀
            'rules' => [
            ],
        ],

    ],
    'params' => $params,
];
