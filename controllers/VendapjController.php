<?php

namespace app\controllers;

use app\models\Servico;
use app\models\Caixa;
use Yii;
use app\models\Vendapj;
use app\models\VendapjSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VendaController implements the CRUD actions for Venda model.
 */
class VendapjController extends Controller
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
     * Lists all Venda models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VendapjSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Venda model.
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
     * Creates a new Venda model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $model = new Vendapj();
        $model_caixa = new Caixa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $servico = Servico::find()->all();
            foreach ($servico as $serv){
                if($serv->id == $model->servico_fk){
                    $model->total = ($model->quantidade *$serv->valor);
                }
            }
            $model->usuario_fk = Yii::$app->user->identity->id;
            $data = date('Y-m-d H:i:s');
            $model->data = $data;
            $model->save();


            $model_caixa->data = $data;
            $model_caixa->total = $model->total;

            $model_caixa->save();

            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Venda model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $servico = Servico::find()->all();
            foreach ($servico as $serv){
                if($serv->id == $model->servico_fk){
                    $model->total = ($model->quantidade *$serv->valor);
                }
            }
            $model->usuario_fk = Yii::$app->user->identity->id;
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Venda model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $venda = Vendapj::find()->all();
        $caixa = Caixa::find()->all();
        $data = 0;
        $idc = 0;

        foreach ($venda as $v){
            if($v->id == $id){
                $data = $v->data;
            }
        }
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
     * Finds the Venda model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Venda the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vendapj::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findCaixa($idc)
    {
        if (($model = Caixa::findOne($idc)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
