<?php

namespace app\controllers;

use app\models\Irpf;
use app\models\Itr;
use Yii;
use app\models\Clienteavulso;
use app\models\ClienteavulsoSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClienteavulsoController implements the CRUD actions for Clienteavulso model.
 */
class ClienteavulsoController extends Controller
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
     * Lists all Clienteavulso models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClienteavulsoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Clienteavulso model.
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
     * Creates a new Clienteavulso model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Clienteavulso();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if($model->irpf == 1){
                $irpf = new Irpf();
                $irpf->cliente_fk = $model->id;
                $irpf->data_entrega = '2020-04-30';
                $irpf->telefone = $model->telefone;
                $irpf->save();
            }

            if($model->itr == 1){
                $itr = new Itr();
                $itr->cliente_fk = $model->id;
                $itr->data_entrega = '2020-09-30';
                $itr->telefone = $model->telefone;
                $itr->save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Clienteavulso model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $irpfs = Irpf::find()->all();
        $itrs = Itr::find()->all();

        $get_irpf = $model->irpf;
        $get_itr = $model->irpf;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //deletar
            if($model->irpf == 0){
                foreach ($irpfs as $item) {
                    if($item->cliente_fk == $model->id){
                        $this->findIrpf($item->id)->delete();
                    }
                }
            }elseif ($model->irpf == 1){
                $aux = 0;
                foreach ($irpfs as $item) {
                    if($item->cliente_fk == $model->id){
                        $aux++;
                    }
                }
                if($aux == 0) {
                    $irpf = new Irpf();
                    $irpf->cliente_fk = $model->id;
                    $irpf->data_entrega = '2020-04-30';
                    $irpf->telefone = $model->telefone;
                    $irpf->save();
                }
            }

            //deletar
            if($model->itr == 0){
                foreach ($itrs as $item) {
                    if($item->cliente_fk == $model->id){
                        $this->findItr($item->id)->delete();
                    }
                }
            }elseif ($model->itr == 1){
                $aux1 = 0;
                foreach ($itrs as $item) {
                    if($item->cliente_fk == $model->id){
                        $aux1++;
                    }
                }
                if($aux1 == 0) {
                    $itr = new Itr();
                    $itr->cliente_fk = $model->id;
                    $itr->data_entrega = '2020-04-30';
                    $itr->telefone = $model->telefone;
                    $itr->save();
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
     * Deletes an existing Clienteavulso model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $itrs = Itr::find()->all();
        $irpfs = Irpf::find()->all();

        $model = $this->findModel($id);

        foreach ($itrs as $item) {
            if($item->cliente_fk == $model->id){
                $this->findItr($item->id)->delete();
            }
        }

        foreach ($irpfs as $item) {
            if($item->cliente_fk == $model->id){
                $this->findIrpf($item->id)->delete();
            }
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Clienteavulso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clienteavulso the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clienteavulso::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findIrpf($id)
    {
        if (($model = Irpf::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Erro ao obter dados do IRPF');
        }
    }

    protected function findItr($id)
    {
        if (($model = Itr::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Erro ao obter dados do ITR');
        }
    }


}
