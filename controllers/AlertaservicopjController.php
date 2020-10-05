<?php

namespace app\controllers;

use app\models\Caixa;
use app\models\Servico;
use Yii;
use app\models\Alertaservicopj;
use app\models\AlertaservicopjSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AlertaservicoController implements the CRUD actions for Alertaservico model.
 */
class AlertaservicopjController extends Controller
{
    /**
     * @inheritdoc
     */
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
                'only' => ['create','update','view','delete','index','prazopj'],
                'rules' => [
                    [
                        'allow'=>true,
                        'roles'=>['@']
                    ]
                ],
            ],
        ];
    }

    /**
     * Lists all Alertaservicopj models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AlertaservicopjSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    //retorna a lista de serviços prontos para entrega
    public function actionPronto()
    {
        $searchModel = new AlertaservicopjSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Alertaservicopj::find()->where(['status_servico' => '1'])
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    //retorna a lista de serviços prontos para entrega
    public function actionPendente()
    {
        $searchModel = new AlertaservicopjSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Alertaservicopj::find()->where(['status_servico' => '0'])
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPrazopj()
    {
        $searchModel = new AlertaservicopjSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Alertaservicopj::find()->where(['status_pagamento' => '0']),
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Alertaservicopj model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Alertaservicopj model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $data = date('Y-m-d H:i:s');
        $model = new Alertaservicopj();
        $model->scenario = "criar";

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->usuario_fk = Yii::$app->user->identity->id;
            $servico = Servico::find()->all();
            $model->status_servico = 0;
            foreach ($servico as $s){
                if(($s->id == $model->servico_fk) && $model->status_pagamento==1){
                    $caixa = new Caixa();
                    $caixa->total = ($s->valor*$model->quantidade);
                    $caixa->data = $data;
                    $model->data_pago = $data;
                    $caixa->save();
                }
            }
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Alertaservicopj model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = "atualiza";

        date_default_timezone_set('America/Sao_Paulo');
        $data = date('Y-m-d H:i:s');
        $servico = Servico::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if($model->status_pagamento == 1 && !$model->data_pago) {
                $caixa = new Caixa();
                $caixa->data = $data;
                foreach ($servico as $s){
                    if($s->id == $model->servico_fk){
                        $caixa->total = ($s->valor * $model->quantidade);
                        $caixa->save();
                        $model->data_pago = $data;
                        $model->save();
                    }
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Alertaservicopj model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $alerta = Alertaservicopj::find()->all();
        $caixa = Caixa::find()->all();
        $data = 0;
        $idc = 0;

        //pega a data no model do alerta
        foreach ($alerta as $a){
            if($a->id == $id){
                $data = $a->data_pago;
            }
        }
        //compara a data do caixa com do alerta e pega o id do caixa para apagar
        foreach ($caixa as $c){
            if($c->data == $data){
                $idc = $c->id;
            }
        }

        $this->findCaixa($idc)->delete();
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Alertaservicopj model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Alertaservicopj the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Alertaservicopj::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findCaixa($idc){
        if (($model = Caixa::findOne($idc)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Dados não encontrados');
        }
    }
}
