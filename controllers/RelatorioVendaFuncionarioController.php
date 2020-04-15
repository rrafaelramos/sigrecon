<?php

namespace app\controllers;
use app\models\RelatorioVendaFuncionario;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class RelatorioVendaFuncionarioController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create','exporta-pdf','view','delete','index'],
                'rules' => [
                    [
                        'allow'=>true,
                        'roles'=>['@']
                    ]
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new RelatorioVendaFuncionario();
        return $this->render('index',[
            'model' => $model,
        ]);
    }

    public function actionExportaPdf(){
        $model = new RelatorioVendaFuncionario();
        $model->load(Yii::$app->request->post());
        RelatorioVendaFuncionario::geraRelatorio($model->inicio, $model->fim, $model->colaborador);
//        $tp->saveAs(Yii::getAlias('@app') . '/documentos/relatorio_venda_funcionario/relatorio_venda_funcionario_temp.docx');
        Yii::$app->response->sendFile(Yii::getAlias('@app') . '/documentos/relatorio_venda_funcionario/relatorio_venda_funcionario_temp.docx');
    }

}