<?php
namespace app\controllers;

use app\models\Abrircaixa;
use app\models\Alertaservico;
use app\models\Alertaservicopj;
use app\models\Caixa;
use app\models\Compra;
use app\models\Servico;
use app\models\Usuario;
use app\models\Venda;
use app\models\Vendapj;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\Controller;

/**
 * AbrircaixaController implements the CRUD actions for Abrircaixa model.
 */
class Relatorio_caixaController extends Controller
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
                'only' => ['create', 'update', 'view', 'delete', 'index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRelatorio()
    {
        $inicio = $_POST['data_inicio'];
        $fim = $_POST['data_fim'];

        if($inicio > $fim){
            return $this->render('erro');
        }

        $abrircaixa = Abrircaixa::find()->all();
        $valor_abertura = 0;

        if($abrircaixa){
            $abertura = Abrircaixa::find()->max('id');
            foreach ($abrircaixa as $a){
                if($abertura == $a->id){
                    if($a->valor){
                        $valor_abertura = $a->valor;
                    }
                }
            }
        }

        $usuarios = Usuario::find()->all();
        $servicos = Servico::find()->all();
        // venda pf
        $vendas = Venda::find()->all();
        //venda pj
        $vendaspj = Vendapj::find()->all();
        //alerta para pf
        $alerta_servicos = Alertaservico::find()->all();
        //alerta para pj
        $alertas_pj = Alertaservicopj::find()->all();
        $caixas = Caixa::find()->all();
        $compras = Compra::find()->all();

        return $this->render('relatorio-comum',[
            'inicio' => $inicio,
            'fim' => $fim,
            'usuarios' => $usuarios,
            'servicos' => $servicos,
            'models' => $vendas,
            'vendaspj' => $vendaspj,
            'valor_abertura' => $valor_abertura,
            'alerta_servicos' => $alerta_servicos,
            'alertas_pj' => $alertas_pj,
            'caixas' => $caixas,
            'compras' => $compras,
        ]);
    }

    public function actionFechamento(){
        $fim = $_GET['data_fim'];
        $inicio = 0;

        $abrircaixa = Abrircaixa::find()->all();
        $valor_abertura = 0;

        $cont = count($abrircaixa);

        if($abrircaixa){
            $abertura = Abrircaixa::find()->max('id');
            if($cont>1){
                $abertura--;
            }
            foreach ($abrircaixa as $a){
                if($abertura == $a->id){
                    $inicio = $a->data;
                    if($a->valor){
                        $valor_abertura = $a->valor;
                    }
                }
            }
        }

        $usuarios = Usuario::find()->all();
        $servicos = Servico::find()->all();
        // venda pf
        $vendas = Venda::find()->all();
        //venda pj
        $vendaspj = Vendapj::find()->all();
        //alerta para pf
        $alerta_servicos = Alertaservico::find()->all();
        //alerta para pj
        $alertas_pj = Alertaservicopj::find()->all();
        $caixas = Caixa::find()->all();
        $compras = Compra::find()->all();

        return $this->render('relatorio-fechamento',[
            'inicio' => $inicio,
            'fim' => $fim,
            'usuarios' => $usuarios,
            'servicos' => $servicos,
            'models' => $vendas,
            'vendaspj' => $vendaspj,
            'valor_abertura' => $valor_abertura,
            'alerta_servicos' => $alerta_servicos,
            'alertas_pj' => $alertas_pj,
            'caixas' => $caixas,
            'compras' => $compras,
        ]);
    }

}
