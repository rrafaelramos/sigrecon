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
                            $aux1 = explode("-",$inicio);
                            $dia1 = $aux1[2];
                            $mes1 = $aux1[1];
                            $ano1 = $aux1[0];
                            if($inicio != $fim){
                                $aux2 = explode("-",$fim);
                                $dia2 = $aux2[2];
                                $mes2 = $aux2[1];
                                $ano2 = $aux2[0];
                                echo "<h4>Honorários recebidos:"." $dia1/$mes1/$ano1"." à "."$dia2/$mes2/$ano2"."</h4>";
                            }else{
                                echo "<h4>Honorários recebidos:"." $dia1/$mes1/$ano1"."</h4>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <?php
                        $valor_honorario = 0;
                        foreach ($honorarios as $honorario) {

                            $aux = explode(" ", $honorario->data_pagamento);
                            $data = $aux[0];

                            if (strtotime($inicio) <= strtotime($data) && strtotime($fim) >= strtotime($data)) {
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
                            $aux1 = explode("-",$inicio);
                            $dia1 = $aux1[2];
                            $mes1 = $aux1[1];
                            $ano1 = $aux1[0];
                            if($inicio != $fim){
                                $aux2 = explode("-",$fim);
                                $dia2 = $aux2[2];
                                $mes2 = $aux2[1];
                                $ano2 = $aux2[0];
                                echo "<h4>Vendas (Pessoa Física):"." $dia1/$mes1/$ano1"." à "."$dia2/$mes2/$ano2"."</h4>";
                            }else{
                                echo "<h4>Vendas (Pessoa Física)"." $dia1/$mes1/$ano1"."</h4>";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="box-body table-responsive">

                        <?php
                        $valor_totalpf = 0;
                        $valor_totalpj = 0;
                        $valor_compra = 0;
                        $valor_pj_receber = 0;
                        $valor_pf_receber = 0;
                        //vendas pf sem alerta
                        foreach ($models as $model) {

                            $aux = explode(" ",$model->data);
                            $data = $aux[0];

                            if (strtotime($inicio) <= strtotime($data) && strtotime($fim) >= strtotime($data)) {
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
                        //alerta de servico para PF
                        if($alerta_servicos){
                            foreach ($alerta_servicos as $alerta_servico) {
                                $aux = explode(" ",$alerta_servico->data_entrega);
                                $data = $aux[0];
                                if (strtotime($inicio) <= strtotime($data) && strtotime($fim) >= strtotime($data)) {
                                    if (($alerta_servico->data_pago == null)){
                                        // colocar o valor pendente
                                        foreach($servicos as $servico){
                                            if($alerta_servico->servico_fk == $servico->id){
                                                $valor_pf_receber += ($servico->valor * $alerta_servico->quantidade);
                                            }
                                        }
                                    }
                                    foreach ($caixas as $caixa){
                                        if ($alerta_servico->data_pago == $caixa->data && strtotime($inicio) <= strtotime($data) && strtotime($fim) >= strtotime($data)){
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
                                                ],
                                            ],
                                        ],
                                    ]);
                                }
                            }
                        }
                        ?>
                        <div class="col-sm-6">
                            <?php echo "<h4>"."Total Vendas PF: ".formatar($valor_totalpf+$valor_pf_receber)."</h4>"; ?>
                            <?php echo "<h4>"."<font color ='#8b0000'>"."À receber: ".formatar($valor_pf_receber)."</font>"."</h4>"; ?>
                        </div>
                        <div class="col-sm-6">
                            <?php echo "<h4>"."<font color ='#006400'>"."Recebidos: ".formatar($valor_totalpf)."</font>"."</h4>"; ?>
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


<!--Vendas para PJ-->
<div class="relatorio-view box box-primary">
    <div class="box-header with-border">
        <div class="panel-body">
            <div class="panel-group collapse in">
                <div class="panel panel-default">
                    <div class="panel-heading with-border col-sm-12">
                        <div class="col-sm-10">
                            <?php
                            $aux1 = explode("-",$inicio);
                            $dia1 = $aux1[2];
                            $mes1 = $aux1[1];
                            $ano1 = $aux1[0];
                            if($inicio != $fim){
                                $aux2 = explode("-",$fim);
                                $dia2 = $aux2[2];
                                $mes2 = $aux2[1];
                                $ano2 = $aux2[0];
                                echo "<h4>Vendas (Pessoa Jurídica):"." $dia1/$mes1/$ano1"." à "."$dia2/$mes2/$ano2"."</h4>";
                            }else{
                                echo "<h4>Vendas (Pessoa Jurídica):"." $dia1/$mes1/$ano1"."</h4>";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="box-body table-responsive">

                        <?php
                        //venda pj
                        foreach ($vendaspj as $vendapj) {
                            $aux = explode(" ",$vendapj->data);
                            $data = $aux[0];
                            if (strtotime($inicio) <= strtotime($data) && strtotime($fim) >= strtotime($data)) {
                                //vendas pj À vista
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
                                ]); ?>
                            <?php }
                        }
                        ?>

                        <?php
                        //alerta de servico para Pj
                        if($alertas_pj){
                            foreach ($alertas_pj as $alerta_pj) {
                                $aux = explode(" ",$alerta_pj->data_entrega);
                                $data = $aux[0];
                                if (strtotime($inicio) <= strtotime($data) && strtotime($fim) >= strtotime($data)) {
                                    if (($alerta_pj->data_pago == null)){
                                        // colocar o valor pendente
                                        foreach($servicos as $servico){
                                            if($alerta_pj->servico_fk == $servico->id){
                                                $valor_pj_receber += ($servico->valor * $alerta_pj->quantidade);
                                            }
                                        }
                                    }
                                    foreach ($caixas as $caixa){
                                        if ($alerta_pj->data_pago == $caixa->data && strtotime($inicio) <= strtotime($data) && strtotime($fim) >= strtotime($data)){
                                            //valor recebido
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
                            <?php echo "<h4>"."Total Vendas PJ: ".formatar($valor_pj_receber+$valor_totalpj)."</h4>"; ?>
                            <?php echo "<h4>"."<font color ='#8b0000'>"."À receber: ".formatar($valor_pj_receber)."</font>"."</h4>"; ?>
                        </div>
                        <div class="col-sm-6">
                            <?php echo "<h4>"."Total Recebido PJ: ".formatar($valor_totalpj)."</h4>"; ?>
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
                            $total = $valor_totalpj+$valor_pj_receber+$valor_totalpf+$valor_pf_receber;
                            echo "<center><h4>"."<font color='#00008b'>"."Total de Vendas:".formatar($total)."</font>"."</h4></center>"; ?>
                        </div>
                        <div class="col-sm-6">
                            <?php
                            echo "<h4>Recebidos PF: "."<font color='#006400'>".formatar($valor_totalpf)."</font>"."</h4>";
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <?php
                            echo "<h4 align='right'>À receber Pf: "."<font color='#8b0000'>".formatar($valor_pf_receber)."</font>"."</h4ali>";
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <?php
                            echo "<h4>Recebidos PJ: "."<font color='#006400'>".formatar($valor_totalpj)."</font>"."</h4>";
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <?php
                            echo "<h4 align='right'>À receber PJ: "."<font color='#8b0000'>".formatar($valor_pj_receber)."</font>"."</h4>";
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <?php
                            echo "<h4 align='left'>Honorários Recebidos:"."<font color='#006400'>".formatar($valor_honorario)."</font >"."</h4>";
                            ?>
                        </div>

                        <div class="col-sm-12">
                            <?php
                            echo "<h3 align='center'>Total Recebido: "."<font color='#006400'>".formatar($valor_totalpj+$valor_totalpf+$valor_honorario)."</font>"."</h3>";
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






