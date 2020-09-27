<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller
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
                'only' => ['update', 'view', 'delete', 'index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ],
        ];
    }

    /**
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuario model.
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
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuario();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->tipo = 0;
            $senha = $model->password;
            $hash = md5($senha);
            $model->password = $hash;
            $model->save();

            return $this->redirect(['novo', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Usuario model.
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
     * Deletes an existing Usuario model.
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
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionNovo($id)
    {
        return $this->render('novo', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionEsqueci()
    {
        $model = new Usuario();
        return $this->render('esqueci', [
            'model' => $model,
        ]);
    }

    public function actionRecuperar()
    {
        $model = new Usuario();
        if ($model->load(Yii::$app->request->post())) {

            $usuarios = Usuario::find()->all();

            foreach ($usuarios as $usuario) {
                if ($model->email == $usuario->email) {
                    $pessoa = $usuario;
                }
            }

            if($pessoa){
                $chave = $this->geraChave($pessoa);
                $pessoa->authKey = $chave;
                $pessoa->save();

                Yii::$app->mailer->compose() //dá para enviar a tela
                ->setFrom('sigrecon.if@gmail.com')
                    ->setTo($pessoa->email)
                    ->setSubject('Recuperação de Senha: SIGRECon') //assunto
//                        ->setHtmlBody()
                    ->setHtmlBody("Olá $pessoa->nome! Para recuperar a sua conta clique no link abaixo".'<br>'.'<a href='."http://localhost/sigrecon/web/index.php?r=usuario%2Fchave&chave=".$chave.'>'.'Clique aqui'.'</a>')
                    ->send();

                return $this->render('recuperar', [
                    'model' => $pessoa,
                ]);
            }else {
                return $this->render('nao-encontrado');
            }
        }
    }


    protected function geraChave($model)
    {
        $chave = sha1($model->id.$model->password);
        return $chave;
    }

    public function actionChave($chave){

        if($_GET["chave"]){

            //compara a chave da url com o authKey
            $usuarios = Usuario::find()->all();
            foreach ($usuarios as $usuario){
                if ($usuario->authKey == $chave){
                    $model = $this->findModel($usuario->id);

                    return $this->render('alterar-senha',[
                        'model' => $model,
                    ]);
                }
            }

            return $this->render('chave-invalida');

        }

    }

    public function actionSalvaSenha($id){

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->password = md5($model->password);
            $model->authKey = md5($model->password.$model->id);
            $model->save();
            return $this->render('senha-alterada');
        }
    }
}