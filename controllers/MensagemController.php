<?php

namespace app\controllers;

use Yii;
use app\models\Mensagem;
use app\models\MensagemSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MensagemController implements the CRUD actions for Mensagem model.
 */
class MensagemController extends Controller
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
     * Lists all Mensagem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MensagemSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Mensagem::find()->where(['receptor' => Yii::$app->user->identity->id])
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mensagem model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $mensagem = $this->findModel($id);
        if(Yii::$app->user->identity->id == $mensagem->receptor) {
            $mensagem->lido = 1;
        }
        $mensagem->save();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Mensagem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mensagem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            date_default_timezone_set('America/Sao_Paulo');
            $model->data_envio = date('Y-m-d');
            $model->emissor = Yii::$app->user->identity->id;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Mensagem model.
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
     * Deletes an existing Mensagem model.
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
     * Finds the Mensagem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mensagem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mensagem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionEnviadas(){
        $searchModel = new MensagemSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Mensagem::find()->where(['emissor' => Yii::$app->user->identity->id])
        ]);
        return $this->render('enviadas', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
