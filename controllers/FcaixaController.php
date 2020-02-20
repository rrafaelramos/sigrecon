<?php

namespace app\controllers;

use app\models\Abrircaixa;
use app\models\Caixa;
use app\models\Compra;
use app\models\Servico;
use Yii;
use app\models\Fcaixa;
use app\models\FcaixaSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FcaixaController implements the CRUD actions for Fcaixa model.
 */
class FcaixaController extends Controller
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
     * Lists all Fcaixa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FcaixaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Fcaixa model.
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
     * Creates a new Fcaixa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $data = date('Y-m-d H:i:s');
        $model = new Fcaixa();
        $caixa = Caixa::find()->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            foreach ($caixa as $c){
                //se o estado for '0' significa que ainda não foi realizado o fechamento
                if($c->estado == 0){
                    if($c->total>0){
                        $model->entrada += $c->total;
                        $c->estado = 1;
                        $c->save();
                    }else{
                        $model->saida += $c->total;
                        $c->estado = 1;
                        $c->save();
                    }
                    $model->saldo = $model->entrada + $model->saida;
                }
            }
            $model->data_fechamento = $data;
            $model->save();

            $abrir_caixa = new Abrircaixa();
            $abrir_caixa->data = $data;
            $abrir_caixa->valor = 0;
            $abrir_caixa->save();

            return $this->redirect(['view', 'id' => $model->id,]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Fcaixa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Fcaixa model.
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
     * Finds the Fcaixa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Fcaixa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fcaixa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionConsulta(){
        $caixa = Caixa::find()->all();
        $entrada = 0;
        $saida = 0;
        $saldo =0;
        foreach ($caixa as $c){
            //se o estado for '0' significa que ainda não foi realizado o fechamento
            if($c->estado == 0){
                if($c->total>0){
                    $entrada += $c->total;
                }else{
                    $saida += $c->total;
                }
                $saldo = $entrada + $saida;
            }
        }
        return $this->render('saldo', ['valor' => $saldo]);
    }

    public function actionSaldo($valor){
        return $this->render('saldo',['valor' => $valor]);
    }
}
