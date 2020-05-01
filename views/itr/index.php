<?php

use app\models\Clienteavulso;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IrpfSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

function cliente($model){
    $clientes = Clienteavulso::find()->all();
    foreach($clientes as $cliente){
        if($cliente->id == $model){
            return $cliente->nome;
        }
    }
}

$this->title = 'Lista ITR';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rotina-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Início', ['site/index'], ['class' => 'btn btn-primary btn-flat']) ?>
    </div>

    <?=  GridView::widget([
        'id' => 'kv-grid-demo',
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//                'id',
            ['attribute' => 'cliente_fk',
                'label' => 'Cliente',
                'value' => function($model){
                    return cliente($model->cliente_fk);
                }
            ],
            ['attribute' => 'telefone',
                'format' => 'html',
                'value' => function($model) {
                    return preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->telefone);
                },
            ],
            ['attribute' => 'data_entrega',
                'label' => 'Data de Entrega',
                'format' => ['date','php:d/m/Y']
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
                                    'label' => Html::tag('i', '', ['class' => 'text-danger fa fa-file-pdf-o']) . ' ' . 'PDF',
                                    'url' => ['exporta-pdf',
                                        'cliente_fk' => (($searchModel->cliente_fk) ? $searchModel->cliente_fk : ((!$searchModel->cliente_fk) ? "" : "")),
                                        'telefone' => (($searchModel->telefone) ? $searchModel->telefone : ((!$searchModel->telefone) ? "" : "")),
                                        'data_entrega' => (($searchModel->data_entrega) ? $searchModel->data_entrega : ((!$searchModel->data_entrega) ? "" : "")),
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
            'heading' => "Listagem de ITR",
        ],
        'persistResize' => false,
        'toggleDataOptions' => ['minCount' => 10],
        'itemLabelSingle' => 'ITR',
        'itemLabelPlural' => 'ITRs'
    ]) ?>





</div>
