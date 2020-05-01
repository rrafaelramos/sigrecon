<?php

use app\models\Avisa_rotina;
use app\models\Empresa;
use app\models\Rotina;
use kartik\grid\GridView;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Avisa_rotinaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Controle de rotina';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
function empresa($model){
    $empresas = Empresa::find()->all();
    foreach ($empresas as $e){
        if($e->id == $model->empresa_fk){
            return "$e->razao_social";
        }
    }
}

function rotina($model){
    return $model->nome_rotina;
}

function chegada($model){
    $rotinas = Rotina::find()->all();
    $doc = 0;
    if($model->nome_rotina == 'DEFIS'){
        return "Extrato do SN - Disponível no portal do Simples Nacional";
    }

    foreach ($rotinas as $r){
        if($r->id == $model->rotina_fk){
            $doc = $r->doc_busca;
        }
    }
    if(!$model->status_chegada){
        return "Aguardando: $doc";
    }else{
        return "$doc recebido(s)!";
    }
}

function entrega($model){
    if(!$model->status_entrega){
        return "Pendente!";
    }elseif ($model->status_entrega == 1){
        return "Pronto para entrega";
    }else{
        return "Entregue";
    }
}
?>

<div class="avisa-rotina-index box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?=  GridView::widget([
            'id' => 'kv-grid-demo',
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                ['attribute' => 'empresa_fk',
                    'label' => 'Empresa',
                    'value' => function($model){
                        return empresa($model);
                    }],
                ['attribute' => 'rotina_fk',
                    'label' => 'Rotina',
                    'value'=> function($model){
                        return rotina($model);
                    }
                ],
                ['attribute' => 'status_chegada',
                    'value' => function($model){
                        return chegada($model);
                    }
                ],
                [
                    'attribute' =>'status_entrega',
                    'label' => 'Status do serviço',
                    'value' => function($model){
                        return entrega($model);
                    }
                ],
                ['attribute' => 'data_entrega',
                    'label' => 'Data Limite',
                    'format' => ['date', 'php: d/m/Y']
                ],
                // 'data_chegada',
                // 'data_pronto',
                ['attribute' => 'data_entregue',
                    'label' => 'Data da entrega',
                    'format' => ['date', 'php: d/m/Y']
                ],
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{view}{update}',
                ],
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
                                            'empresa_fk' => (($searchModel->empresa_fk) ? $searchModel->empresa_fk : ((!$searchModel->empresa_fk) ? "" : "")),
                                            'rotina_fk' => (($searchModel->rotina_fk) ? $searchModel->rotina_fk : ((!$searchModel->rotina_fk) ? "" : "")),
                                            'data_entrega' => (($searchModel->data_entrega) ? $searchModel->data_entrega : ((!$searchModel->data_entrega) ? "" : "")),
                                            'status_chegada' => (($searchModel->status_chegada) ? $searchModel->status_chegada : ((!$searchModel->status_chegada) ? "" : "")),
                                            'status_entrega' => (($searchModel->status_entrega) ? $searchModel->status_entrega : ((!$searchModel->status_entrega) ? "" : "")),
                                            'data_entregue' => (($searchModel->data_entregue) ? $searchModel->data_entregue : ((!$searchModel->data_entregue) ? "" : "")),
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
                'heading' => "Controle de Rotina",
            ],
            'persistResize' => false,
            'toggleDataOptions' => ['minCount' => 10],
            'itemLabelSingle' => 'Documento',
            'itemLabelPlural' => 'Documentos'
        ]) ?>
    </div>
</div>