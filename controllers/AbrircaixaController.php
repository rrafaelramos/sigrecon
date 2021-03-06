<?php

namespace app\controllers;

use app\models\Caixa;
use Yii;
use app\models\Abrircaixa;
use app\models\AbrircaixaSearch;
use yii\bootstrap\Alert;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AbrircaixaController implements the CRUD actions for Abrircaixa model.
 */
class AbrircaixaController extends Controller
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
     * Lists all Abrircaixa models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect(['create']);
//        $searchModel = new AbrircaixaSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
    }

    /**
     * Displays a single Abrircaixa model.
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
     * Creates a new Abrircaixa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //verifica se o caixa está aberto
        $caixa = Caixa::find()->all();
        $cont = count($caixa);
        $cont2 =0;
        foreach ($caixa as $c){
            if($c->estado == 1 ){
                $cont2++;
            }
        }
        //caixa já está abertp
        if($cont != $cont2){
            return $this->render('caixa_aberto');
        }

        date_default_timezone_set('America/Sao_Paulo');
        $data = date('Y-m-d H:i:s');

        $model = new Abrircaixa();
        $caixa = new Caixa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $caixa->total = $model->valor;
            $caixa->data = $data;
            $model->data = $data;
            $model->save();
            $caixa->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Abrircaixa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //atualiza o valor salvo no caixa
            $caixas = Caixa::find()->all();

            foreach ($caixas as $caixa){
                if($caixa->data == $model->data){
                    $model_caixa = $this->findCaixa($caixa->id);
                    $model_caixa->total = $model->valor;
                    $model_caixa->save();
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
     * Deletes an existing Abrircaixa model.
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
     * Finds the Abrircaixa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Abrircaixa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Abrircaixa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findCaixa($id)
    {
        if (($model = Caixa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
