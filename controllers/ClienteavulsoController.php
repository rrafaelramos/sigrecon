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

            //verifica se é um cliente do IRPF
            if($model->rotina == '2'){
                $irpf = new Irpf();
                $irpf->cliente_fk = $model->id;
                $irpf->data_entrega = '2020-04-30';
                $irpf->telefone = $model->telefone;
                $irpf->save();
            }
            //verifica se é um cliente do ITR
            if($model->rotina == '3'){
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

        $rotina = $model->rotina;

        $irpf = Irpf::find()->all();
        $itr = Itr::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if($rotina){
                if($model->rotina != $rotina && $model->rotina == 2){
                    // se a nova rotina é irpf, deleta do ITR
                    foreach ($itr as $it){
                        if($it->cliente_fk == $model->id){
                            $this->findItr($it->id)->delete();
                        }
                    }
                    //apos apagar de itr insere em IRPF
                    $model_irpf = new Irpf();
                    $model_irpf->cliente_fk = $model->id;
                    $model_irpf->data_entrega = '2020-04-30';
                    $model_irpf->telefone = $model->telefone;
                    $model_irpf->save();
                }elseif($model->rotina != $rotina && $model->rotina == 3){
                    // se a nova rotina é irpf, deleta do ITR
                    foreach ($irpf as $ir){
                        if($ir->cliente_fk == $model->id){
                            $this->findIrpf($ir->id)->delete();
                        }
                    }
                    //apos apagar de irpf insere em itr
                    $model_itr = new Itr();
                    $model_itr->cliente_fk = $model->id;
                    $model_itr->data_entrega = '2020-09-30';
                    $model_itr->telefone = $model->telefone;
                    $model_itr->save();
                }
            }elseif(!$rotina && $model->rotina == 2){
                $model_irpf = new Irpf();
                $model_irpf->cliente_fk = $model->id;
                $model_irpf->data_entrega = '2020-04-30';
                $model_irpf->telefone = $model->telefone;
                $model_irpf->save();
            }elseif(!$rotina && $model->rotina == 3){
                $model_itr = new Itr();
                $model_itr->cliente_fk = $model->id;
                $model_itr->data_entrega = '2020-09-30';
                $model_itr->telefone = $model->telefone;
                $model_itr->save();
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
        $model = $this->findModel($id);

        $this->findModel($id)->delete();

        if($model->rotina == 2){
            $irpf = Irpf::find()->all();
            foreach ($irpf as $i){
                if($i->cliente_fk == $model->id){
                    $this->findIrpf($i->id)->delete();
                }
            }
        }elseif ($model->rotina == 3){
            $itr = Itr::find()->all();
            foreach ($itr as $i){
                if($i->cliente_fk == $model->id){
                    $this->findItr($i->id)->delete();
                }
            }
        }
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
