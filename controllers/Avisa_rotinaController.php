<?php

namespace app\controllers;

use Yii;
use app\models\Avisa_rotina;
use app\models\Avisa_rotinaSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Avisa_rotinaController implements the CRUD actions for Avisa_rotina model.
 */
class Avisa_rotinaController extends Controller
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
     * Lists all Avisa_rotina models.
     * @return mixed
     */

    public function actionIndex()
    {
        $searchModel = new Avisa_rotinaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    //lista todos os docs sendo aguardados
    public function actionAguardando(){
        $searchModel = new Avisa_rotinaSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Avisa_rotina::find()->where(['status_chegada' => '0'])
        ]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // lista os docs pendentes
    public function actionPendente(){
        $searchModel = new Avisa_rotinaSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Avisa_rotina::find()->where(['status_entrega' => '0'])
        ]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // lista os docs prontos para entrega
    public function actionPronto(){
        $searchModel = new Avisa_rotinaSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Avisa_rotina::find()->where(['status_entrega' => '1'])
        ]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // lista os docs entregues
    public function actionEntregue(){
        $searchModel = new Avisa_rotinaSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Avisa_rotina::find()->where(['status_entrega' => '2'])
        ]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Avisa_rotina model.
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
     * Creates a new Avisa_rotina model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Avisa_rotina();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Avisa_rotina model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if($model->status_chegada == 1){
                $model->data_chegada = date('Y-m-d');
                $model->save();
            }
            if ($model->status_entrega == 1){
                $model->data_pronto = date('Y-m-d');
                $model->save();
            }elseif ($model->status_entrega == 2 && !$model->data_pronto) {
                $model->data_entregue = date('Y-m-d');
                $model->data_pronto = date('Y-m-d');
                $model->save();
            }elseif ($model->status_entrega == 2){
                $model->data_entregue = date('Y-m-d');
                $model->save();
            }

            return $this->redirect(['index']);

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Avisa_rotina model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Avisa_rotina model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Avisa_rotina the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Avisa_rotina::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportaPdf($empresa_fk,$rotina_fk,$data_entrega,$status_chegada,$status_entrega,$data_entregue){
        Avisa_rotina::geraRotina($empresa_fk,$rotina_fk,$data_entrega,$status_chegada,$status_entrega,$data_entregue);
        Yii::$app->response->sendFile(Yii::getAlias('@app') . '/documentos/avisarotina/avisarotina_temp.docx');
    }
}
