<?php

namespace app\controllers;

use app\models\Alertaservico;
use app\models\Alertaservicopj;
use Yii;
use app\models\Lembrete;
use app\models\LembreteSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LembreteController implements the CRUD actions for Lembrete model.
 */
class LembreteController extends Controller
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
     * Lists all Lembrete models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $searchModel = new LembreteSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $lembretes = Lembrete::find()->all();

        $events = [];
        foreach ($lembretes as $lembrete) {
            if($lembrete->usuario_fk == Yii::$app->user->identity->id) {
                $event = new \yii2fullcalendar\models\Event();
                $event->id = $lembrete->id;
                $event->title = $lembrete->titulo;
                $event->start = $lembrete->data;
                if($lembrete->alerta_pf || $lembrete->alerta_pj){
                    $event->color = '#8B0000';
                }
                $events[] = $event;
            }
        }

        return $this->render('index', [
            'events' => $events,
        ]);
    }

    /**
     * Displays a single Lembrete model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id,$titulo)
    {
        $lembrete = Lembrete::find()->all();

        foreach ($lembrete as $lemb){
            if($lemb->titulo == $titulo){
                return $this->renderAjax('view', [
                    'model' => $this->findModel($lemb->id),
                ]);
            }
        }
    }

    /**
     * Creates a new Lembrete model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($date)
    {
        $model = new Lembrete();
        $model->data = $date;
        $model->usuario_fk = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post())) {

            date_default_timezone_set('America/Sao_Paulo');
            $dat = date('Y-m-d');

            if(strtotime($model->data) < strtotime($dat)){
                return $this->render('_erro', [
                    'model' => $model,
                ]);
            }

            $model->save();

            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Lembrete model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            date_default_timezone_set('America/Sao_Paulo');
            $dat = date('Y-m-d');

            if(strtotime($model->data) < strtotime($dat)){
                return $this->render('_erro', [
                    'model' => $model,
                ]);
            }

            $model->save();

            if($model->alerta_pf){
                $modelpf = $this->findPf($model->alerta_pf);
                $modelpf->data_entrega = $model->data;
                $modelpf->save();
            }

            if($model->alerta_pj){
                $modelpj = $this->findPj($model->alerta_pj);
                $modelpj->data_entrega = $model->data;
                $modelpj->save();
            }

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Lembrete model.
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
     * Finds the Lembrete model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lembrete the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lembrete::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findPf($id)
    {
        if (($model = Alertaservico::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findPj($id)
    {
        if (($model = Alertaservicopj::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
