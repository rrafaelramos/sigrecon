<?php

namespace app\controllers;

use app\models\Avisa_rotina;
use app\models\Rotina;
use Yii;
use app\models\Empresa;
use app\models\EmpresaSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * EmpresaController implements the CRUD actions for Empresa model.
 */
class EmpresaController extends Controller
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
                'only' => ['create','update','view','delete','index','datavenc'],
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
     * Lists all Empresa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmpresaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Empresa model.
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
     * Creates a new Empresa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Empresa();

        date_default_timezone_set('America/Sao_Paulo');
        $data = date('Y-m-d');
        $dataaux = explode("-",$data);
        $anoatual = $dataaux[0];
        $mesatual = $dataaux[1];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //1 é o id do simples nacional
            if($model->rotina == 1) {
                // insere na tabela os DAS
                $model_avisa = new Avisa_rotina();
                $model_avisa->empresa_fk = $model->id;
                $model_avisa->rotina_fk = $model->rotina;

                $rotinas = Rotina::find()->all();
                foreach ($rotinas as $r) {
                    if ($model_avisa->rotina_fk == $model->rotina) {
                        $dataaux = explode("-", $r->data_entrega);
                        $dia = $dataaux[2];
                    }
                }
                $model_avisa->data_entrega = "$anoatual-$mesatual-$dia";
                $model_avisa->nome_rotina = 'Simples Nacional';
                $model_avisa->gera_auto = $data;
                $model_avisa->status_chegada = 0;
                $model_avisa->status_entrega = 0;
                $model_avisa->save();
            }
            if($model->rotina == 1 && $mesatual == '03') {
                // insere na tabela os DAS
                $model_avisa = new Avisa_rotina();
                $model_avisa->empresa_fk = $model->id;
                $model_avisa->rotina_fk = $model->rotina;

                $rotinas = Rotina::find()->all();
                foreach ($rotinas as $r) {
                    if ($model_avisa->rotina_fk == $model->rotina) {
                        $dataaux = explode("-", $r->data_entrega);
                        $dia = $dataaux[2];
                    }
                }
                $model_avisa->data_entrega = "$anoatual-$mesatual-31";
                $model_avisa->nome_rotina = 'DEFIS';
                $model_avisa->gera_auto = $data;
                $model_avisa->status_chegada = 1;
                $model_avisa->status_entrega = 0;
                $model_avisa->save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Empresa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Empresa model.
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
     * Finds the Empresa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Empresa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Empresa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDatavenc()
    {
        $searchModel = new EmpresaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('datavenc', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
