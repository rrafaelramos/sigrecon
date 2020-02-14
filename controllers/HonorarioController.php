<?php

namespace app\controllers;

use app\models\Caixa;
use Yii;
use app\models\Honorario;
use app\models\HonorarioSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HonorarioController implements the CRUD actions for Honorario model.
 */
class HonorarioController extends Controller
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
                'only' => ['create','update','view','delete','index'],
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
     * Lists all Honorario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HonorarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Honorario model.
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
     * Creates a new Honorario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $data = date('Y-m-d');
        $data_caixa = date('Y-m-d H:i:s');

        $model = new Honorario();
        $caixa = new Caixa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->usuario_fk = Yii::$app->user->identity->id;
            $model->data_pagamento = $data;
            $model->data_caixa = $data_caixa;
            $model->save();

            $caixa->data = $data_caixa;
            $caixa->total = $model->valor;
            $caixa->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Honorario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $caixas = Caixa::find()->all();

            //pega o model no bd
            foreach ($caixas as $caixa) {
                if($caixa->data == $model->data_caixa){
                    $modelcaixa = $this->findCaixa($caixa->id);
                    $modelcaixa->total = $model->valor;
                    $modelcaixa->save();
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
     * Deletes an existing Honorario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $honorarios = Honorario::find()->all();
        $caixas = Caixa::find()->all();
        $data = 0;
        $idcaixa = 0;

        foreach ($honorarios as $honorario){
            if($honorario->id == $id){
                $data = $honorario->data_caixa;
            }
        }

        foreach ($caixas as $caixa) {
            if($caixa->data == $data){
                $idcaixa = $caixa->id;
            }
        }

        $this->findModel($id)->delete();
        $this->findCaixa($idcaixa)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Honorario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Honorario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Honorario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findCaixa($idcaixa)
    {
        if (($model = Caixa::findOne($idcaixa)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
