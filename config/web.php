<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

use kartik\datecontrol\Module;

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'formatter' => [
            'dateFormat' => 'dd/mm/yyyy',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'pt-br',
        ],
    //'components' => [
        /*'view' => [
            'theme' => [
                'pathMap' => [
                   '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                ],
            ],
       ],*/
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'xNKAEvcjFWFpAr1PEqoN2qVGni6qT2Cp',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],

    'modules' => [
        'gridview' =>  [
             'class' => '\kartik\grid\Module'
             // enter optional module parameters below - only if you need to  
             // use your own export download action or custom translation 
             // message source
             // 'downloadAction' => 'gridview/export/download',
             // 'i18n' => []
         ],
         /*'admin' => [
             'class' => 'mdm\admin\Module',
         ], */
         
         'datecontrol' =>  [
             'class' => '\kartik\datecontrol\Module',
             'displaySettings' => [
                 Module::FORMAT_DATE => 'dd/MM/yyyy',
                 Module::FORMAT_TIME => 'HH:mm',
                 Module::FORMAT_DATETIME => 'dd/MM/yyyy HH:mm',
             ],
             'saveSettings' => [
                 Module::FORMAT_DATE => 'php:Y-m-d',
                 Module::FORMAT_TIME => 'php:H:i:s',
                 Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
             ],
             // automatically use kartik\widgets for each of the above formats
             'autoWidget' => true,
             // converte data entre formatos de displaySettings e saveSettings via chamada ajax.
             'ajaxConversion' => true,
             'autoWidgetSettings' => [
                 Module::FORMAT_DATE => ['type' => 2, 'pluginOptions' => ['autoclose' => true]],
                 Module::FORMAT_DATETIME => [],
                 Module::FORMAT_TIME => [],
             ],
         ],
     ],
 


    'params' => $params,
];

if (YII_ENV_DEV) {    
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [ // HERE
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'adminlte' => '@vendor/dmstr/yii2-adminlte-asset/gii/templates/crud/simple',
                ]
            ]
        ],
    ];
}

return $config;
