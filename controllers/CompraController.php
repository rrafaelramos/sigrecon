<?php

namespace app\controllers;

use app\models\Caixa;
use Yii;
use app\models\Compra;
use app\models\CompraSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompraController implements the CRUD actions for Compra model.
 */
class CompraController extends Controller
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
                'only' => ['create','update','view','delete','index','saida'],
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
     * Lists all Compra models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompraSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Compra model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionViewsaida($id)
    {
        return $this->render('viewsaida', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Compra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $data = date('Y-m-d H:i:s');

        $caixa = new Caixa();
        $model = new Compra();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->data = $data;
            $model->usuario_fk = Yii::$app->user->identity->id;
            $caixa->data = $data;
            $caixa->total -= $model->valor;
            $model->save();
            $caixa->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionSaida(){
        date_default_timezone_set('America/Sao_Paulo');
        $data = date('Y-m-d H:i:s');

        $caixa = new Caixa();
        $model = new Compra();
        $model->quantidade = 1;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->data = $data;

            $model->usuario_fk = Yii::$app->user->identity->id;
            $caixa->data = $data;
            $caixa->total -= $model->valor;

            $model->save();
            $caixa->save();

            return $this->redirect(['viewsaida', 'id' => $model->id]);
        } else {
            return $this->render('saida', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Updates an existing Compra model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $caixa = Caixa::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            foreach ($caixa as $c){
                if($c->data == $model->data){
                    $pegacaixa = $this->findCaixa($c->id);
                    $pegacaixa->total = 0;
                    $pegacaixa->data = $model->data;
                    $pegacaixa->total -= $model->valor;
                    $pegacaixa->save();
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
     * Deletes an existing Compra model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $caixa = Caixa::find()->all();

        $model = $this->findModel($id);

        //compara se a data de inserção no caixa é igual a data do model e chama o delete()
        foreach ($caixa as $c){
            if($c->data == $model->data){
                $this->findCaixa($c->id)->delete();
            }
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Compra model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Compra the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Compra::findOne($id)) !== null) {
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
