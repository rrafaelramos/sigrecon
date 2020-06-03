<?php

namespace app\controllers;

use app\models\Dctf;
use app\models\Ecf;
use app\models\Rais;
use Yii;
use app\models\Associacao;
use app\models\AssociacaoSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AssociacaoController implements the CRUD actions for Associacao model.
 */
class AssociacaoController extends Controller
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
     * Lists all Associacao models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AssociacaoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Associacao model.
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
     * Creates a new Associacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Associacao();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            date_default_timezone_set('America/Sao_Paulo');
            $data = date('Y');

            $rais = new Rais();
            $rais->associacao_id = $model->id;
            $rais->associacao_nome = $model->razao_social;
            $rais->data_limite = "$data-02-28";
            $rais->presidente = $model->responsavel;
            $rais->fone_presidente = $model->telefone_socio;
            $rais->feito = 'Não';
            $rais->save();

            $dctf = new Dctf();
            $dctf->associacao_id = $model->id;
            $dctf->associacao_nome = $model->razao_social;
            $dctf->data_limite = "$data-03-31";
            $dctf->presidente = $model->responsavel;
            $dctf->fone_presidente = $model->telefone_socio;
            $dctf->feito = 'Não';
            $dctf->save();

            $ecf = new Ecf();
            $ecf->associacao_id = $model->id;
            $ecf->associacao_nome = $model->razao_social;
            $ecf->data_limite = "$data-07-31";
            $ecf->presidente = $model->responsavel;
            $ecf->fone_presidente = $model->telefone_socio;
            $ecf->feito = 'Não';
            $dctf->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Associacao model.
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
     * Deletes an existing Associacao model.
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
     * Finds the Associacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Associacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Associacao::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDatavenc()
    {
        $searchModel = new AssociacaoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('datavenc', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExportaPdf($razao_social, $data_procuracao, $data_certificado, $telefone_socio, $responsavel){
        Associacao::geraDataVenc($razao_social, $data_procuracao, $data_certificado, $telefone_socio, $responsavel);
        Yii::$app->response->sendFile(Yii::getAlias('@app') . '/documentos/data_venc/data_venc_temp.docx');
    }
}
