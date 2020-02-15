<?php

use app\models\Clienteavulso;
use app\models\Empresa;
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

function empresa($model){
    $empresa = Empresa::find()->all();
    foreach ($empresa as $e) {
        if ($e->id == $model->empresa_fk) {
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

function quantidade($model){
    if($model>1){
        return "$model unidades";
    }
    return "$model unidade";
}

$this->title = "Fechamento Caixa";
$this->params['breadcrumbs'][] = "Caixa";
$this->params['breadcrumbs'][] = "Fechar Caixa";
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
                        $valor_honorario = 0;
                        foreach ($honorarios as $honorario) {

//                            $aux = explode(" ", $honorario->data_pagamento);
//                            $data = $aux[0];

                            if (strtotime($inicio) <= strtotime($honorario->data_pagamento) && strtotime($fim) >= strtotime($honorario->data_pagamento)) {
                                $valor_honorario += $honorario->valor;

                                echo DetailView::widget([
                                    'model' => $honorario,
                                    'condensed' => true,
                                    'bordered' => true,
                                    'striped' => false,
                                    'enableEditMode' => false,
                                    'mode' => \kartik\detail\DetailView::MODE_VIEW,
                                    'attributes' => [
                                        //'id',
                                        [
                                            'columns' => [
                                                ['attribute' => 'empresa_fk',
                                                    'label' => 'Empresa',
                                                    'value' => empresa($honorario),
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                                ['attribute' => 'valor',
                                                    'label' => 'Valor Pago',
                                                    'value' => formatar($honorario->valor),
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                            ],
                                        ],
                                        [
                                            'columns' => [
                                                ['attribute' => 'referencia',
                                                    'format' => ['date', 'php:d/m/Y'],
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                                ['attribute' => 'data_pagamento',
                                                    'label' => 'Data de Pagamento',
                                                    'format' => ['date', 'php:d/m/Y'],
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                            ],
                                        ],
                                        [
                                            'columns' => [
                                                ['attribute' => 'usuario_fk',
                                                    'label' => 'Usuário',
                                                    'value' => usuario($honorario),
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                                ['attribute' => 'observacao',
                                                    'label' => 'Observação',
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                            ],
                                        ],
                                    ],
                                ])
                                ?>
                            <?php }
                        }?>
                        <div class="col-sm-6">
                            <?php echo "<h4>"."<font color ='#006400'>"."Honorários recebidos: ".formatar($valor_honorario)."</font>"."</h4>"; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



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
                        $valor_totalpf = 0;
                        $valor_totalpj = 0;
                        $valor_compra = 0;
                        //venda pf
                        foreach ($models as $model) {
                            $data = explode(" ",$model->data);
                            if (strtotime($inicio) <= strtotime($model->data) && strtotime($fim) >= strtotime($model->data)) {
                                $valor_totalpf += $model->total;
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

                        <?php
                        if($valor_abertura) {
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
                        //alerta de servico para PF
                        if($alerta_servicos){
                            foreach ($alerta_servicos as $alerta_servico) {
                                if (strtotime($inicio) <= strtotime($alerta_servico->data_pago) && strtotime($fim) >= strtotime($alerta_servico->data_pago)) {
                                    foreach ($caixas as $caixa){
                                        if ($alerta_servico->data_pago == $caixa->data && strtotime($inicio) <= strtotime($alerta_servico->data_pago) && strtotime($fim) >= strtotime($alerta_servico->data_pago)){
                                            $valor_totalpf += $caixa->total;
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
                            <?php echo "<h4>"."Total Vendas PF: ".formatar($valor_totalpf)."</h4>"; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Daki para baixo é a vertificação de venda para pj-->
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
                        //venda pj
                        foreach ($vendaspj as $vendapj) {
                            $data = explode(" ",$model->data);
                            if (strtotime($inicio) <= strtotime($vendapj->data) && strtotime($fim) >= strtotime($vendapj->data)) {
                                $valor_totalpj += $vendapj->total;
                                ?>
                                <?= DetailView::widget([
                                    'model' => $vendapj,
                                    'condensed' => true,
                                    'bordered' => true,
                                    'striped' => false,
                                    'enableEditMode' => false,
                                    'mode' => DetailView::MODE_VIEW,
                                    'attributes' => [
                                        [
                                            'columns' => [
                                                [
                                                    'label' => 'Empresa:',
                                                    'value' => empresa($vendapj),
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                                [
                                                    'label' => 'Código da venda:',
                                                    'value' => $vendapj->id,
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                            ],
                                        ],
                                        [
                                            'columns' => [
                                                [
                                                    'label' => 'Serviço:',
                                                    'value' => servico($vendapj),
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                                [
                                                    'label' => 'Valor Unitário:',
                                                    'value' => valor($vendapj->servico_fk),
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                            ],
                                        ],
                                        [
                                            'columns' => [
                                                [
                                                    'label' => 'Data da Venda:',
                                                    'value' => $vendapj->data,
                                                    'format' => ['date', 'php:d/m/Y'],
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                                [
                                                    'label' => 'Quantidade:',
                                                    'value' => "$vendapj->quantidade x " . valor($vendapj->servico_fk),
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                            ],
                                        ],
                                        [
                                            'columns' => [
                                                [
                                                    'label' => 'Atendente:',
                                                    'value' => responsavel($vendapj),
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                                [
                                                    'label' => 'Total:',
                                                    'value' => formatar($vendapj->total),
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

                        <?php
                        //alerta de servico para Pj
                        if($alertas_pj){
                            foreach ($alertas_pj as $alerta_pj) {
                                if (strtotime($inicio) <= strtotime($alerta_pj->data_pago) && strtotime($fim) >= strtotime($alerta_pj->data_pago)) {
                                    foreach ($caixas as $caixa){
                                        if ($alerta_pj->data_pago == $caixa->data && strtotime($inicio) <= strtotime($alerta_pj->data_pago) && strtotime($fim) >= strtotime($alerta_pj->data_pago)){
                                            $valor_totalpj += $caixa->total;
                                        }
                                    }
                                    ?>

                                    <?= DetailView::widget([
                                        'model' => $alerta_pj,
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
                                                        'value' =>  servico($alerta_pj),
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                    [
                                                        'label' => 'Data de entrega',
                                                        'value' => $alerta_pj->data_entrega,
                                                        'format' => ['date', 'php:d/m/Y'],
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                ],
                                            ],
                                            [
                                                'columns' => [
                                                    [
                                                        'label' => 'Empresa',
                                                        'value' => empresa($alerta_pj),
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                    [
                                                        'label' => 'Informações adicionais',
                                                        'value' => $alerta_pj->info,
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                ],
                                            ],
                                            [
                                                'columns' => [
                                                    [
                                                        'label' => 'Valor Unitário:',
                                                        'value' => valor($alerta_pj->servico_fk),
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                    [
                                                        'label' => 'Quantidade:',
                                                        'value' => "$alerta_pj->quantidade x ".valor($alerta_pj->servico_fk),
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                ],
                                            ],
                                            [
                                                'columns' => [
                                                    [
                                                        'label' => 'Status do Serviço',
                                                        'value' => statusServico($alerta_pj),
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                    [
                                                        'label' => 'Total',
                                                        'value' => total($alerta_pj),
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
                                                        'value' => statusPagamento($alerta_pj),
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                    [
                                                        'label' => 'Responsável pelo servico',
                                                        'value' => responsavel($alerta_pj),
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ]);
                                }
                            }
                        }
                        ?>
                        <div class="col-sm-6">
                            <?php echo "<h4>"."Total Vendas PJ: ".formatar($valor_totalpj)."</h4>"; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="relatorio-view box box-primary">
    <div class="box-header with-border">
        <div class="panel-body">
            <div class="panel-group collapse in">
                <div class="panel panel-default">
                    <div class="panel-heading with-border col-sm-12">
                        <div class="col-sm-10">
                            <?php
                            echo "<h4>Retiradas:</h4>";
                            ?>
                        </div>
                    </div>
                    <div class="box-body table-responsive">

                        <?php
                        foreach ($compras as $compra) {
                            $data = explode(" ", $compra->data);
                            if (strtotime($inicio) <= strtotime($compra->data) && strtotime($fim) >= strtotime($compra->data)) {
                                $valor_compra += $compra->valor;
                                ?>
                                <?= DetailView::widget([
                                    'model' => $compra,
                                    'condensed' => true,
                                    'bordered' => true,
                                    'striped' => false,
                                    'enableEditMode' => false,
                                    'mode' => DetailView::MODE_VIEW,
                                    'attributes' => [
                                        [
                                            'columns' => [
                                                [
                                                    'label' => 'Descrição',
                                                    'value' =>  $compra->descricao,
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
//                                                [
//                                                    'label' => 'Quantidade',
//                                                    'value' => quantidade($compra->quantidade),
//                                                    'labelColOptions' => ['style' => 'width:15%'],
//                                                    'valueColOptions' => ['style' => 'width:35%'],
//                                                ],
                                            ],
                                        ],
                                        [
                                            'columns' => [
                                                [
                                                    'label' => 'Data',
                                                    'value' =>  $compra->data,
                                                    'format' => ['date', 'php: d/m/Y'],
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                                [
                                                    'label' => 'Valor total',
                                                    'value' =>  formatar($compra->valor),
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                            ],
                                        ],
                                        [
                                            'columns' => [
                                                [
                                                    'label' => 'Usuário',
                                                    'value' =>  usuario($compra),
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                            ],
                                        ],
                                    ],
                                ]);
                            }
                        }
                        ?>
                        <div class="col-sm-6">
                            <?php echo "<h4>"."Total Retiradas: ".formatar($valor_compra)."</h4>"; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--Resumo das Operações-->
<div class="relatorio-view box box-primary">
    <div class="box-header with-border">
        <div class="panel-body">
            <div class="panel-group collapse in">
                <div class="panel panel-default">
                    <div class="panel-heading with-border col-sm-12">
                        <div class="col-sm-10">
                            <?php
                            echo "<h4>Resumo Geral:</h4>";
                            ?>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <div class="col-sm-12">
                            <?php
                            echo "<h4>Vendas PF: "."<font color='#006400'>".formatar($valor_totalpf)."</font>"."</h4>";
                            ?>
                        </div>
                        <div class="col-sm-12">
                            <?php
                            echo "<h4>Vendas PJ: "."<font color='#006400'>".formatar($valor_totalpj)."</font>"."</h4>";
                            ?>
                        </div>
                        <div class="col-sm-12">
                            <?php echo "<h4>"."Honorários Recebidos: "."<font color='#006400'>".formatar($valor_honorario)."</font>"."</h4>"; ?>
                        </div>
                        <div class="col-sm-6 pull-right">
                            <?php
                            echo "<h4 class='pull-right'>Retiradas: "."<font color='#8b0000'>".formatar($valor_compra)."</font>"."</h4>";
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <?php echo "<h4>"."Valor Abertura do Caixa: "."<font color='#00008b'>".formatar($valor_abertura)."</font>"."</h4>"; ?>
                        </div>
                        <div class="col-sm-12">
                            <?php
                            $saldo = (($valor_totalpf+$valor_totalpj+$valor_abertura+$valor_honorario)-$valor_compra);
                            if(!$saldo){
                                echo "<h3>Saldo da operação: "."<font color='black'>".formatar($saldo) ."</font>"."</h3>";
                            }elseif($saldo>0) {
                                echo "<h3>Saldo da operação: "."<font color='#228b22'>"."+ ".formatar($saldo) ."</font>"."</h3>";
                            }elseif($saldo<0){
                                echo "<h3>Saldo da operação: "."<font color='#8b0000'>".formatar($saldo) ."</font>"."</h3>";
                            }
                            ?>
                        </div>
                        <div class="col-sm-12">
                            <?= Html::a('Finalizar', ['/site/index'], ['class' => 'btn btn-primary btn-flat pull-right']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



