<?php

use app\models\Servico;
use app\models\Usuario;
use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\Clienteavulso;

/* @var $this yii\web\View */
/* @var $model app\models\Alertaservico */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Alertaservicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
function servico($model){
    $servico = Servico::find()->all();
    foreach ($servico as $s){
        if($s->id == $model->servico_fk){
            return $s->descricao;
        }
    }
}

function cliente($model){
    $cliente = Clienteavulso::find()->all();
    foreach ($cliente as $c) {
        if ($c->id == $model->cliente_fk) {
            return $c->nome;
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
        if($model) {
            $formatado = $formatter->asDecimal($model);
            $valor = "R$ ".$formatado;
            return $valor;
        }else
        return 'R$ 0,00';
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
            return Yii::$app->user->identity->nome;
        }
    }

}
?>

<div class="alertaservico-view box box-primary">
    <div class="box-header with-border">
        <!--        <div class="col-sm-12">-->
        <h4>Dados do Alerta</h4>
    </div>
    <div class="panel-body">
        <div class="panel-group collapse in">
            <div class="panel panel-default">
                <div class="panel-heading with-border col-xs-12">
                    <div class="col-xs-10">
                        <h2 class="panel-title">Informações Gerais</h2>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <?= DetailView::widget([
                        'model' => $model,
                        'condensed' => true,
                        'bordered' => true,
                        'striped' => false,
                        'enableEditMode' => false,
                        'mode' => \kartik\detail\DetailView::MODE_VIEW,
                        'attributes' => [
                            [
                                'columns' => [
                                    [
                                        'label' => 'Serviço',
                                        'value' =>  servico($model),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                    [
                                        'label' => 'Data de entrega',
                                        'value' => $model->data_entrega,
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
                                        'value' => cliente($model),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                    [
                                        'label' => 'Informações adicionais',
                                        'value' => $model->info,
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'label' => 'Valor Unitário:',
                                        'value' => valor($model->servico_fk),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                    [
                                        'label' => 'Quantidade:',
                                        'value' => "$model->quantidade x ".valor($model->servico_fk),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'label' => 'Status do Serviço',
                                        'value' => statusServico($model),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                    [
                                        'label' => 'Total',
                                        'value' => total($model),
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
                                        'value' => statusPagamento($model),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],[
                                        'label' => 'Responsável pelo servico',
                                        'value' => responsavel($model),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                    //'id',
                                ],
                            ],
                        ],
                    ]) ?>
                    <div class="col-sm-12">
                        <?= Html::a('Cancelar', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-flat',
                            'data' => [
                                'confirm' => 'Deseja realmente excluir?',
                                'method' => 'post',
                            ],
                        ]) ?>
                        <?= Html::a('Confirmar', ['index'], ['class' => 'btn btn-success btn-flat pull-right']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

