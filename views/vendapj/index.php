<?php

use app\models\Empresa;
use app\models\Servico;
use app\models\Usuario;
use app\models\Alertaservicopj;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VendaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vendas PJ';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
function empresa($model){
    $empresa = Empresa::find()->all();
    foreach ($empresa as $e){
        if($e->id == $model->empresa_fk){
            return $e->razao_social;
        }
    }
}

function empresaAlerta($alertapj){
    $empresas = Empresa::find()->all();
    foreach ($empresas as $e){
        if($e->id == $alertapj){
            return $e->razao_social;
        }
    }
}

function usuario($model){
    $usuario = Usuario::find()->all();
    foreach ($usuario as $u){
        if($u->id == $model->usuario_fk){
            return $u->nome;
        }
    }
}

function servico($model){
    $servico = Servico::find()->all();
    foreach ($servico as $s){
        if($s->id == $model->servico_fk){
            return $s->descricao;
        }
    }
}

function servicoAlerta($alertapj){
    $servicos = Servico::find()->all();
    foreach ($servicos as $s){
        if($s->id == $alertapj->servico_fk){
            return $s->descricao;
        }
    }
}

function formatar($model){
    $formatter = Yii::$app->formatter;
    if($model) {
        $formatado = $formatter->asDecimal($model,2);
        $valor = "R$ ".$formatado;
        return $valor;
    }else
        return 'R$ 0,00';
}

function statusPag($model){
    if($model == '0'){
        return 'Pago!';
    }
    return 'Aguardando pagamento!';
}

function pagamentoAlerta($alertapj){
    if($alertapj->status_pagamento == 0){
        return 'Aguardando Pagamento';
    }elseif ($alertapj->status_pagamento == 1){
        return 'Pago';
    }else{
        return 'Pago no honorário';
    }
}

function statusAlerta($alertapj){
    if($alertapj->status_servico == 0){
        return 'Pendente';
    }elseif ($alertapj->status_servico == 1){
        return 'Pronto para entrega';
    }else{
        return 'Entregue';
    }
}
?>
<div class="servico-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Novo +', ['create'], ['class' => 'btn btn-success btn-flat'])?>
        <?= Html::a('Voltar', ['site/index'], ['class' => 'btn btn-primary btn-flat pull-right'])?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'hover' => 'true',
            'resizableColumns'=>'true',
            'responsive' => 'true',
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],
//                ['attribute' => 'id',
//                    'label' => 'N° da Venda',
//                ],
                // 'data',
                ['attribute' =>'empresa_fk',
                    'label' => 'Empresa',
                    'value' => function($model){
                        return empresa($model);
                    }],
                ['attribute' => 'servico_fk',
                    'label' => 'Serviço',
                    'value' => function($model){
                        return servico($model);
                    }
                ],
                // 'quantidade',
                [
                    'attribute' => 'total',
                    'value' => function($model){
                        return formatar($model->total);
                    }
                ],
                [
                    'attribute' => 'form_pagamento',
                    'label' => 'Status do pagamento',
                    'value' => function($model){
                        return statusPag($model->form_pagamento);
                    }

                ],
                ['attribute' => 'data',
                    'format' => ['date','php:d/m/Y']
                ],
                ['attribute' => 'usuario_fk',
                    'label' => 'Vendedor',
                    'value' => function($model){
                        return usuario($model);
                    }],
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{view}{delete}',
                ],
            ],
        ]); ?>
    </div>
</div>

<div class="servico-index box box-primary">
    <div class="box-body table-responsive">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Alertas de Serviço</h3>
            </div>
            <div class="box-header with-border">
                <?= Html::a('Novo Alerta +', ['alertaservicopj/create'], ['class' => 'btn btn-success btn-flat'])?>
                <?= Html::a('Voltar', ['site/index'], ['class' => 'btn btn-primary btn-flat pull-right'])?>
            </div>
            <div class="box-body table-responsive no-padding">
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <?php
                $search = new \app\models\AlertaservicopjSearch();
                $alertapj = $search->search(Yii::$app->request->queryParams);
                $modelAlerta = \app\models\Alertaservicopj::find()->all();
                $grid1 = GridView::widget(['dataProvider' => $alertapj,
                    'hover' => 'true',
                    'resizableColumns'=>'true',
                    'responsive' => 'true',
                    'layout' => "{items}\n{summary}\n{pager}",
                    'columns' => [
                        [
                            'attribute' => 'cliente_fk',
                            'label' => 'Cliente',
                            'value' => function($alertapj){
                                return empresaAlerta($alertapj->empresa_fk);
                            },

                        ],
                        ['attribute' => 'data_entrega',
                            'label' => 'Data de Entrega',
                            'format' =>['date','php:d/m/Y']
                        ],
                        ['attribute' => 'servico_fk',
                            'label' => 'Serviço',
                            'value' => function($alertapj){
                                return servicoAlerta($alertapj);
                            }],
                        //'quantidade',
                        // 'info:ntext',
                        ['attribute' => 'status_pagamento',
                            'label' => 'Situação do Pagamento',
                            'value' => function($alertapj){
                                return pagamentoAlerta($alertapj);
                            }],
                        ['attribute' => 'status_servico',
                            'label' => 'Status',
                            'value' => function ($alertapj){
                                return statusAlerta($alertapj);
                            }],
                        // 'usuario_fk',
                        [
                            'class' => '\kartik\grid\ActionColumn',
                            'template' => '{view}{delete}',

                            'buttons' => [
                                'view' => function($url, $alertapj) {
                                    return Html::a('<span><b class="fa fa-eye"></b></span>',
                                        [
                                            'alertaservicopj/view',
                                            'id' => $alertapj->id,

                                        ],
                                        [
                                            'title' => 'Vizualizar unidade',
                                            'id' => 'modal-btn-view'
                                        ]);
                                },
                                'delete' => function($url, $alertapj) {
                                    return Html::a('<span<b class="fa fa-trash"></b></span>',
                                        ['/alertaservicopj/apaga', 'id' => $alertapj->id],
                                        ['title' => 'Excluir',
                                            'class' => '',
                                            'data' => ['confirm' => 'Deseja realmente excluir este alerta?', 'method' => 'post', 'data-pjax' => false],
                                        ]);
                                },
                            ],
                        ],
                    ],
                ]);
                echo $grid1.'<br><br>';
                ?>
            </div>
        </div>
    </div>
</div>
