<?php

namespace app\controllers;

use app\models\Clienteavulso;
use app\models\Itr;
use app\models\ItrSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class ItrController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view','delete','index'],
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
        $searchModel = new ItrSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id){

        $model = $this->findModel($id);

        $clientes = Clienteavulso::find()->all();

        foreach ($clientes as $cliente){
            if($cliente->id == $model->cliente_fk){
                return $this->redirect(['clienteavulso/view', 'id' => $cliente->id]);
            }
        }
    }

    protected function findModel($id){
        if (($model = Itr::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }

    public function actionExportaPdf($cliente_fk, $telefone, $data_entrega){
        Itr::geraItr($cliente_fk, $telefone, $data_entrega);
        Yii::$app->response->sendFile(Yii::getAlias('@app') . '/documentos/itr/itr_temp.docx');
    }

}
