<?php

namespace app\controllers;

use app\models\Abrircaixa;
use app\models\Servico;
use app\models\Caixa;
use Yii;
use app\models\Venda;
use app\models\VendaSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VendaController implements the CRUD actions for Venda model.
 */
class VendaController extends Controller
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
        $searchModel = new VendaSearch();
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
        $model = new Venda();
        $model_caixa = new Caixa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $servico = Servico::find()->all();
            foreach ($servico as $serv){
                if($serv->id == $model->servico_fk){
                    $model->total = (($model->quantidade *$serv->valor) - $model->desconto);
                    $model_caixa->total = $model->total;
                    $model->tot_sem_desconto = $model->quantidade *$serv->valor;
                }
            }
            $model->usuario_fk = Yii::$app->user->identity->id;
            $data = date('Y-m-d H:i:s');
            $model->data = $data;
            $model->save();

            $model_caixa->data = $data;
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
                    if($model->desconto) {
                        $model->total = (($model->quantidade * $serv->valor) - $model->desconto);
                    }else{
                        $model->total = ($model->quantidade * $serv->valor);
                    }
                    $model->tot_sem_desconto = $model->quantidade *$serv->valor;
                }
            }

            if($model->desconto > $model->tot_sem_desconto){
                return $this->render('_formErro', [
                    'id' => $model->id,
                    'model' => $model,
                ]);
            }

            $caixas = Caixa::find()->all();
            foreach ($caixas as $caixa){
                if ($caixa->data == $model->data){
                    $model_caixa = $this->findCaixa($caixa->id);
                    $model_caixa->total = $model->total;
                    $model_caixa->save();
                }
            }

            $model->usuario_fk = Yii::$app->user->identity->id;
            $model->save();

            $verifica_abrircaixa = Abrircaixa::find()->all();

            if(!$verifica_abrircaixa) {
                $abrir_caixa = new Abrircaixa();
                $abrir_caixa->data = $model->data;
                $abrir_caixa->save();
            }

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
        $venda = Venda::find()->all();
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
        if (($model = Venda::findOne($id)) !== null) {
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
