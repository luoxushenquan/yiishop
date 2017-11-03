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
    //�����ļ����ã�false��ʾ�رգ�
//    'layout'=>'mine',
    //Ĭ��·��
//  'defaultRoute' => 'stu/list',
//    'defaultRoute' => 'tianqi/index',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            //�ƶ�ʵ����֤�ӿ�
            'class'=>'yii\web\user',
            'identityClass' => 'frontend\models\admin',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            //Ĭ�ϵ�½ҳ��
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
//��ַ����
        'urlManager' => [
            'enablePrettyUrl' => true,//����������ַ
            'showScriptName' => false,//�Ƿ���ʾ�ű��ļ�
            // 'suffix'=>'.html',//α��̬��׺
            'rules' => [
            ],
        ],

    ],
    'params' => $params,
];
