<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\bootstrap\ButtonDropdown;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmpresaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Procurações e Certificados';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
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

<!-- --><?php
//$gridColumns = [
//    'razao_social',
//    ['attribute' => 'data_procuracao',
//        'label' => 'Vencimento Procuração',
//        'value' => function($model){
//            return procurac($model);
//        }
//    ],
//    ['attribute' => 'data_certificado',
//        'label' => 'Vencimento Certificado',
//        'value' => function($model){
//            return certifica($model);
//        }
//    ],
//    'responsavel',
//    'telefone_socio'
//];
//
//echo ExportMenu::widget([
//    'dataProvider' => $dataProvider,
//    'columns' => $gridColumns,
//    'exportConfig' => [
//        ExportMenu::FORMAT_CSV => false,
//        ExportMenu::FORMAT_HTML => false,
//        ExportMenu::FORMAT_TEXT => false,
//    ],
//]);
?>

<div class="empresa-index box box-primary">

<!--    --><?php //echo Html::a('Voltar', ['site/index'], ['class' => 'btn btn-primary btn-flat pull-right']) ?>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


        <!--                --><?php //echo GridView::widget([
        //            'dataProvider' => $dataProvider,
        //            'filterModel' => $searchModel,
        //            'hover' => 'true',
        //            'resizableColumns'=>'true',
        //            'responsive' => 'true',
        //            'layout' => "{items}\n{summary}\n{pager}",
        //            'columns' => [
        //               // ['class' => 'yii\grid\SerialColumn'],
        //                //'id',
        ////                ['attribute' => 'cnpj',
        ////                    'format' => 'html',
        ////                    'value' => function($model) {
        ////                        return preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '${1}.${2}.${3}/${4}-${5}', $model->cnpj);
        ////                    },
        ////                ],
        //                ['attribute' => 'razao_social',
        //                    'label' => 'Empresa'],
        //                //'nome_fantasia',
        //                //'email:email',
        ////                ['attribute' => 'telefone',
        ////                    'format' => 'html',
        ////                    'value' => function($model) {
        ////                        return preg_replace('/^(\d{2})(\d{4})(\d{4})$/', '(${1}) ${2}-${3}', $model->telefone);
        ////                    },
        ////                ],
        //                // 'celular',
        //                // 'numero',
        //                // 'complemento',
        //                // 'rua',
        //                // 'bairro',
        //                // 'cidade',
        //                // 'cep',
        //                // 'uf',
        //                //'format' => ['date','php:d/m/Y'],
        //                // 'data_abertura',
        //                [ 'attribute' => 'data_procuracao',
        //                    'value' => function($model){
        //                        return procurac($model);
        //                    }
        //                ],
        //                ['attribute' => 'data_certificado',
        //                    'value' => function($model){
        //                        return certifica($model);
        //                    }
        //
        //                ],
        //                // 'rotina',
        //                'responsavel',
        //                // 'cpf_socio',
        //                // 'datanascimento_socio',
        //                // 'rg',
        //                // 'titulo',
        //                // 'nome_mae_socio',
        //                ['attribute' => 'telefone_socio',
        //                    'format' => 'html',
        //                    'value' => function($model) {
        //                        return preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->celular);
        //                    },
        //                ],
        //                // 'usuario_fk',
        //
        //                [
        //                    'class' => '\kartik\grid\ActionColumn',
        //                    'template' => '{view}{update}',
        //                ],
        //
        //            ],
        //        ]); ?>

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
                        return preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->celular);
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
                                        'label' => Html::tag('i', '', ['class' => 'text-danger fa fa-file-pdf-o']) . ' ' . 'PDF',
                                        'url' => ['exporta-pdf',
                                            'responsavel' => (($searchModel->responsavel) ? $searchModel->responsavel : ((!$searchModel->responsavel) ? "" : "")),
//                                            'situacao' => (($searchModel->situacao) ? $searchModel->situacao : ((!$searchModel->situacao) ? "" : "")),
//                                            'classificacao' => (($searchModel->classificacao) ? $searchModel->classificacao : ((!$searchModel->classificacao) ? "" : "")),
//                                            'tipoEstagio' => (($searchModel->tipoEstagio) ? $searchModel->tipoEstagio : ((!$searchModel->tipoEstagio) ? "" : "")),
//                                            'dataI' => (($searchModel->dataI) ? $searchModel->dataI : ((!$searchModel->dataI) ? "" : "")),
//                                            'dataF' => (($searchModel->dataF) ? $searchModel->dataF : ((!$searchModel->dataF) ? "" : "")),
//                                            'mes' => (($searchModel->mes) ? $searchModel->mes : ((!$searchModel->mes) ? "" : "")),
//                                            'ano' => (($searchModel->ano) ? $searchModel->ano : ((!$searchModel->ano) ? "" : "")),
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
                //'heading' => "Listagem de todos os estágios por curso",
            ],
            'persistResize' => false,
            'toggleDataOptions' => ['minCount' => 10],
            'itemLabelSingle' => 'Curso',
            'itemLabelPlural' => 'Cursos'
        ]) ?>
    </div>
</div>