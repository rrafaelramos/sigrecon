<?php

use app\models\Clienteavulso;
use app\models\Servico;
use app\models\Usuario;
use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $models app\controllers\Relatorio_caixaController */

function cliente($model){
    $cliente = Clienteavulso::find()->all();
    foreach ($cliente as $c) {
        if ($c->id == $model->cliente_fk) {
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

function valor($model){
    $servico = Servico::find()->all();
    //encontra o servico pelo id passado: ($model)
    foreach ($servico as $s){
        if($s->id == $model){
            //chama a função para formatar para real
            return formatar($s->valor);
        }
    }
}

function formatar($model){
    $formatter = Yii::$app->formatter;
    if(!$model){
        return 'R$ 0,00';
    }
    $formatado = $formatter->asCurrency($model);
    $dinheiro = str_replace("pt-br", "R$", $formatado);
    return $dinheiro;
}

function total($model){
    $s =0;
    $servico = Servico::find()->all();

    foreach($servico as $serv){
        if($serv->id == $model->servico_fk){
            $s = $serv->valor;
            $s *= $model->quantidade;
            return formatar($s);
        }
    }
}

function statusPagamento($model){
    if($model->status_pagamento == 0){
        return 'Aguardando Pagamento';
    }elseif ($model->status_pagamento == 1){
        return 'Pago';
    }else{
        return 'Pago no Honorário';
    }
}

function statusServico($model){
    if($model->status_servico == 0){
        return 'Pendente';
    }elseif ($model->status_servico == 1){
        return 'Pronto para Entrega';
    }else{
        return 'Entregue';
    }
}

function responsavel($model){
    $usuario = Usuario::find()->all();
    foreach ($usuario as $u){
        if($u->id == $model->usuario_fk){
            return $u->nome;
        }
    }
}

$this->title = "Relatório de Vendas";
$this->params['breadcrumbs'][] = ['label' => 'Vendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relatorio-view box box-primary">
    <div class="box-header with-border">
        <div class="panel-body">
            <div class="panel-group collapse in">
                <div class="panel panel-default">
                    <div class="panel-heading with-border col-sm-12">
                        <div class="col-sm-10">
                            <?php
                            $aux1 = explode(" ",$inicio);
                            $aux1_data = $aux1[0];
                            $aux1_hora = $aux1[1];
                            $data1 = explode("-",$aux1_data);
                            $dia1 = $data1[2];
                            $mes1 = $data1[1];
                            $ano1 = $data1[0];
                            if($inicio != $fim){
                                $aux2 = explode(" ",$fim);
                                $aux2_data = $aux2[0];
                                $aux2_hora = $aux2[1];
                                $data2=explode("-",$aux2_data);
                                $dia2 = $data2[2];
                                $mes2 = $data2[1];
                                $ano2 = $data2[0];
                                echo "<h4>Relatório:"." $dia1/$mes1/$ano1 às $aux1_hora"." à "."$dia2/$mes2/$ano2 às $aux2_hora"."</h4>";
                            }else{
                                echo "<h4>Relatório do dia:"." $dia1/$mes1/$ano1"."</h4>";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="box-body table-responsive">

                        <?php
                        $valor_total = 0;
                        foreach ($models as $model) {
                            $data = explode(" ",$model->data);
                            if (strtotime($inicio) <= strtotime($model->data) && strtotime($fim) >= strtotime($model->data)) {
                                $valor_total += $model->total;
                                ?>
                                <?= DetailView::widget([
                                    'model' => $model,
                                    'condensed' => true,
                                    'bordered' => true,
                                    'striped' => false,
                                    'enableEditMode' => false,
                                    'mode' => DetailView::MODE_VIEW,
                                    'attributes' => [
                                        [
                                            'columns' => [
                                                [
                                                    'label' => 'Cliente:',
                                                    'value' => cliente($model),
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                                [
                                                    'label' => 'Código da venda:',
                                                    'value' => $model->id,
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                            ],
                                        ],
                                        [
                                            'columns' => [
                                                [
                                                    'label' => 'Serviço:',
                                                    'value' => servico($model),
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                                [
                                                    'label' => 'Valor Unitário:',
                                                    'value' => valor($model->servico_fk),
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                            ],
                                        ],
                                        [
                                            'columns' => [
                                                [
                                                    'label' => 'Data da Venda:',
                                                    'value' => $model->data,
                                                    'format' => ['date', 'php:d/m/Y'],
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                                [
                                                    'label' => 'Quantidade:',
                                                    'value' => "$model->quantidade x " . valor($model->servico_fk),
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                            ],
                                        ],
                                        [
                                            'columns' => [
                                                [
                                                    'label' => 'Atendente:',
                                                    'value' => responsavel($model),
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                                [
                                                    'label' => 'Total:',
                                                    'value' => formatar($model->total),
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                            ],
                                        ],
                                    ],
                                ]) ?>
                            <?php }
                        }
                        ?>

                        <?php if($valor_abertura) {
                            DetailView::widget([
                                'model' => $valor_abertura,
                                'condensed' => true,
                                'bordered' => true,
                                'striped' => false,
                                'enableEditMode' => false,
                                'mode' => DetailView::MODE_VIEW,
                                'attributes' => [
                                    [
                                        'columns' => [
                                            [
                                                'label' => 'Abertura do caixa:',
                                                'value' => formatar($valor_abertura),
                                                'labelColOptions' => ['style' => 'width:15%'],
                                                'valueColOptions' => ['style' => 'width:35%'],
                                            ],
                                        ],
                                    ],
                                ],
                            ]);
                        }
                        ?>

                        <?php
                        if($alerta_servicos){
                            foreach ($alerta_servicos as $alerta_servico) {
                                if (strtotime($inicio) <= strtotime($alerta_servico->data_pago) && strtotime($fim) >= strtotime($alerta_servico->data_pago)) {
                                    foreach ($caixas as $caixa){
                                        if ($alerta_servico->data_pago == $caixa->data && strtotime($inicio) <= strtotime($alerta_servico->data_pago) && strtotime($fim) >= strtotime($alerta_servico->data_pago)){
                                            $valor_total += $caixa->total;
                                        }
                                    }
                                    ?>

                                    <?= DetailView::widget([
                                        'model' => $alerta_servico,
                                        'condensed' => true,
                                        'bordered' => true,
                                        'striped' => false,
                                        'enableEditMode' => false,
                                        'mode' => DetailView::MODE_VIEW,
                                        'attributes' => [
                                            [
                                                'columns' => [
                                                    [
                                                        'label' => 'Serviço',
                                                        'value' =>  servico($alerta_servico),
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                    [
                                                        'label' => 'Data de entrega',
                                                        'value' => $alerta_servico->data_entrega,
                                                        'format' => ['date', 'php:d/m/Y'],
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                ],
                                            ],
                                            [
                                                'columns' => [
                                                    [
                                                        'label' => 'Cliente',
                                                        'value' => cliente($alerta_servico),
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                    [
                                                        'label' => 'Informações adicionais',
                                                        'value' => $alerta_servico->info,
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                ],
                                            ],
                                            [
                                                'columns' => [
                                                    [
                                                        'label' => 'Valor Unitário:',
                                                        'value' => valor($alerta_servico->servico_fk),
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                    [
                                                        'label' => 'Quantidade:',
                                                        'value' => "$alerta_servico->quantidade x ".valor($alerta_servico->servico_fk),
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                ],
                                            ],
                                            [
                                                'columns' => [
                                                    [
                                                        'label' => 'Status do Serviço',
                                                        'value' => statusServico($alerta_servico),
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                    [
                                                        'label' => 'Total',
                                                        'value' => total($alerta_servico),
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                ],
                                            ],
                                            [
                                                'columns' => [
                                                    [
                                                        'label' => 'Status do pagamento',
                                                        'attribute' => 'Status do Pagamento',
                                                        'value' => statusPagamento($alerta_servico),
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],[
                                                        'label' => 'Responsável pelo servico',
                                                        'value' => responsavel($alerta_servico),
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                    //'id',
                                                ],
                                            ],
                                        ],
                                    ]);
                                }
                            }
                        }
                        ?>
                        <div class="col-sm-6">
                            <?php echo "<h4>"."Valor total: ".formatar($valor_total)."</h4>"; ?>
                        </div>
                        <div class="col-sm-6">
                            <?= Html::a('Finalizar', ['/site/index'], ['class' => 'btn btn-primary btn-flat pull-right']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

