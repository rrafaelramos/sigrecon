<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\bootstrap\ButtonDropdown;
use app\models\Contabilidade;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmpresaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Empresas';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php

if (!Contabilidade::find()->all() && Yii::$app->user->identity->tipo == 1) {
    echo '<center><h2>É necessário primeiramente configurar os dados da contabilidade<br><h1>';
    echo
    Html::a(
        '<span class="fa fa-gear"></span> Configurar',
        ['/contabilidade/create'],
        ['data-method' => 'post', 'class' => 'btn btn-success btn-flat']
    );
} else {


    date_default_timezone_set('America/Sao_Paulo');
    function procurac($model){
        if(strtotime($model->data_procuracao) > strtotime(date("Y-m-d"))){
            //retorna a data do model, e transforma em um array
            $dataprocuracao = explode('-',$model->data_procuracao);
            $dia = $dataprocuracao[2];
            $mes = $dataprocuracao[1];
            $ano = $dataprocuracao[0];
            return "$dia/$mes/$ano";
        }elseif(strtotime($model->data_procuracao) == strtotime(date("Y-m-d"))){
            return 'Hoje!';
        }else{
            return 'Expirou!';
        }
    }

    function certifica($model){
        if(strtotime($model->data_certificado) > strtotime(date("Y-m-d"))){
            date_default_timezone_set('America/Sao_Paulo');
            $datacertificado = explode('-',$model->data_certificado);
            $diac = $datacertificado[2];
            $mesc = $datacertificado[1];
            $anoc = $datacertificado[0];
            return "$diac/$mesc/$anoc";
        }elseif(strtotime($model->data_certificado) == strtotime(date("Y-m-d"))){
            return 'Hoje!';
        }else{
            return 'Expirou';
        }
    }
    ?>

    <div class="empresa-index box box-primary">

        <!--    --><?php //echo Html::a('Voltar', ['site/index'], ['class' => 'btn btn-primary btn-flat pull-right']) ?>
        <div class="box-body table-responsive no-padding">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?=  GridView::widget([
                'id' => 'kv-grid-demo',
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'razao_social',
                    [ 'attribute' => 'data_procuracao',
                        'value' => function($model){
                            return procurac($model);
                        }
                    ],
                    ['attribute' => 'data_certificado',
                        'value' => function($model){
                            return certifica($model);
                        }

                    ],
                    ['attribute' => 'telefone_socio',
                        'format' => 'html',
                        'value' => function($model) {
                            return preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->telefone_socio);
                        },
                    ],
                    'responsavel',
                ],
                'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                'filterRowOptions' => ['class' => 'kartik-sheet-style'],
                'pjax' => false, // pjax is set to always true for this demo
                // set your toolbar
                'toolbar' => [
                    [
                        'content'=>
                            ButtonDropdown::widget([
                                'label' => '<i class="fa fa-share-square-o"></i>',
                                'encodeLabel' => false,
                                'options' => [
                                    'title' => 'Exportar',
                                    'class' => 'btn btn-default dropdown-toggle',
                                ],
                                'dropdown' => [
                                    'items' => [
                                        [
                                            'label' => 'Exportar os Registros dessa Página',
                                            'class' => 'dropdown-header',
                                        ],
                                        [
                                            'label' => Html::tag('i', '', ['class' => 'text-danger fa fa-file-text-o']) . ' ' . 'DOC',
                                            'url' => ['exporta-pdf',
                                                'razao_social' => (($searchModel->razao_social) ? $searchModel->razao_social : ((!$searchModel->razao_social) ? "" : "")),
                                                'data_procuracao' => (($searchModel->data_procuracao) ? $searchModel->data_procuracao : ((!$searchModel->data_procuracao) ? "" : "")),
                                                'data_certificado' => (($searchModel->data_certificado) ? $searchModel->data_certificado : ((!$searchModel->data_certificado) ? "" : "")),
                                                'celular' => (($searchModel->telefone_socio) ? $searchModel->telefone_socio : ((!$searchModel->telefone_socio) ? "" : "")),
                                                'responsavel' => (($searchModel->responsavel) ? $searchModel->responsavel : ((!$searchModel->responsavel) ? "" : "")),
                                            ],
                                            'encode' => false,
                                            'options' => [
                                                'title' => 'Documento PDF',
                                            ]
                                        ],
                                    ],
                                    'options' => [
                                        'class' => 'dropdown-menu dropdown-menu-right',
                                    ]
                                ],
                            ]),
                    ],
                ],
                'toggleDataContainer' => ['class' => 'btn-group mr-2'],
                // set export properties
                'export' => [
                    'fontAwesome' => true
                ],
                // parameters from the demo form
                'bordered' => true,
                'striped' => true,
                'condensed' => true,
                'responsive' => true,
                'hover' => true,
                'showPageSummary' => false,
                'panel' => [
                    'type' => GridView::TYPE_DEFAULT,
                    'heading' => "Empresas: Certificados e Procurações",
                ],
                'persistResize' => false,
                'toggleDataOptions' => ['minCount' => 10],
                'itemLabelSingle' => 'Certificado',
                'itemLabelPlural' => 'Certificados'
            ]) ?>
        </div>
    </div>
    <?php
}
?>