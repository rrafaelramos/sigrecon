<?php

use app\models\Clienteavulso;
use app\models\Servico;
use app\models\Usuario;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VendaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Serviços PF';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
function cliente($model){
    $cliente = Clienteavulso::find()->all();
    foreach ($cliente as $c){
        if($c->id == $model->cliente_fk){
            return $c->nome;
        }
    }
}

function clienteAlerta($model){
    $clientes = Clienteavulso::find()->all();
    foreach ($clientes as $c){
        if($c->id == $model){
            return $c->nome;
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

function servicoAlerta($alerta){
    $servico = Servico::find()->all();
    foreach ($servico as $s){
        if($s->id == $alerta->servico_fk){
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

function pagamentoAlerta($alerta){
    if($alerta->status_pagamento == 0){
        return 'Aguardando Pagamento';
    }elseif ($alerta->status_pagamento == 1){
        return 'Pago';
    }else{
        return 'Pago no honorário';
    }
}

function statusAlerta($alerta){
    if($alerta->status_servico == 0){
        return 'Pendente';
    }elseif ($alerta->status_servico == 1){
        return 'Pronto para entrega';
    }else{
        return 'Entregue';
    }
}
?>

<div class="servico-index box box-primary">
    <div class="box-body table-responsive">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Serviços PF</h3>
            </div>
            <div class="box-header with-border">
                <?= Html::a('Novo +', ['create'], ['class' => 'btn btn-success btn-flat'])?>
                <?= Html::a('Voltar', ['site/index'], ['class' => 'btn btn-primary btn-flat pull-right'])?>
            </div>
            <div class="box-body table-responsive no-padding">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
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
                        ['attribute' =>'cliente_fk',
                            'label' => 'Cliente',
                            'value' => function($model){
                                return cliente($model);
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
    </div>
</div>



<div class="servico-index box box-primary">
    <div class="box-body table-responsive">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Alertas de Serviço</h3>
            </div>
            <div class="box-header with-border">
                <?= Html::a('Novo Alerta +', ['alertaservico/create'], ['class' => 'btn btn-success btn-flat'])?>
                <?= Html::a('Voltar', ['site/index'], ['class' => 'btn btn-primary btn-flat pull-right'])?>
            </div>
            <div class="box-body table-responsive no-padding">
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <?php
                $search = new \app\models\AlertaservicoSearch();
                $alerta = $search->search(Yii::$app->request->queryParams);
                $modelAlerta = \app\models\Alertaservico::find()->all();
                $grid1 = GridView::widget(['dataProvider' => $alerta,
                    'hover' => 'true',
                    'resizableColumns'=>'true',
                    'responsive' => 'true',
                    'layout' => "{items}\n{summary}\n{pager}",
                    'columns' => [
                        [
                            'attribute' => 'cliente_fk',
                            'label' => 'Cliente',
                            'value' => function($alerta){
                                return clienteAlerta($alerta->cliente_fk);
                            },

                        ],
                        ['attribute' => 'data_entrega',
                            'label' => 'Data de Entrega',
                            'format' =>['date','php:d/m/Y']
                        ],
                        ['attribute' => 'servico_fk',
                            'label' => 'Serviço',
                            'value' => function($alerta){
                                return servicoAlerta($alerta);
                            }],
                        //'quantidade',
                        // 'info:ntext',
                        ['attribute' => 'status_pagamento',
                            'label' => 'Situação do Pagamento',
                            'value' => function($alerta){
                                return pagamentoAlerta($alerta);
                            }],
                        ['attribute' => 'status_servico',
                            'label' => 'Status',
                            'value' => function ($alerta){
                                return statusAlerta($alerta);
                            }],
                        // 'usuario_fk',
                        [
                            'class' => '\kartik\grid\ActionColumn',
                            'template' => '{view}{delete}',

                            'buttons' => [
                                'view' => function($url, $alerta) {
                                    return Html::a('<span><b class="fa fa-eye"></b></span>',
                                        [
                                            'alertaservico/view',
                                            'id' => $alerta->id,

                                        ],
                                        [
                                            'title' => 'Vizualizar unidade',
                                            'id' => 'modal-btn-view'
                                        ]);
                                },
                                'delete' => function($url, $alerta) {
                                    return Html::a('<span<b class="fa fa-trash"></b></span>',
                                        ['/alertaservico/apaga', 'id' => $alerta->id],
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
