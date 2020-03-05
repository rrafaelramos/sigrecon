<?php

use app\models\Clienteavulso;
use app\models\Servico;
use app\models\Usuario;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Venda */

$servico = Servico::find()->all();
$nome_ser = 0;
//pega a descrição do servico
foreach ($servico as $ser){
    if($ser->id == $model->servico_fk){
        $nome_ser = $ser->descricao;
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
    if($model == 0){
        return "R$ 0,00";
    }
    $formatter = Yii::$app->formatter;
    $formatado = $formatter->asCurrency($model);
    $dinheiro = str_replace("pt-br", "R$", $formatado);
    return $dinheiro;
}

$this->title = "Venda de: $nome_ser";
$this->params['breadcrumbs'][] = ['label' => 'Vendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresa-view box box-primary">
    <div class="box-header with-border">
        <div class="panel-body">
            <div class="panel-group collapse in">
                <div class="panel panel-default">
                    <div class="panel-heading with-border col-xs-12">
                        <div class="col-xs-10">
                            <h4>Dados Gerais</h4>
                        </div>
                    </div>

                    <div class="box-body table-responsive">

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
                                            'label' => 'Serviço:',
                                            'value' => servico($model),
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
                                            'label' => 'Data da Venda:',
                                            'value' => $model->data,
                                            'format' => ['date', 'php:d/m/Y'],
                                            'labelColOptions' => ['style' => 'width:15%'],
                                            'valueColOptions' => ['style' => 'width:35%'],
                                        ],
                                        [
                                            'label' => 'Valor Venda:',
                                            'value' => formatar($model->tot_sem_desconto),
                                            'labelColOptions' => ['style' => 'width:15%'],
                                            'valueColOptions' => ['style' => 'width:35%'],
                                        ],
                                    ],
                                ],
                                [
                                    'columns' => [
                                        [
                                            'label' => 'Atendente:',
                                            'value' => usuario($model),
                                            'labelColOptions' => ['style' => 'width:15%'],
                                            'valueColOptions' => ['style' => 'width:35%'],
                                        ],
                                        [
                                            'label' => 'Desconto:',
                                            'value' => "- ".formatar($model->desconto),
                                            'labelColOptions' => ['style' => 'width:15%'],
                                            'valueColOptions' => ['style' => 'width:35%'],
                                        ],
                                    ],
                                ],
                                [
                                    'columns' => [
                                        [
                                            'label' => 'Total recebido:',
                                            'value' => formatar($model->total),
                                            'labelColOptions' => ['style' => 'width:15%'],
                                            'valueColOptions' => ['style' => 'width:35%'],
                                        ],
                                    ],
                                ],
                            ],
                        ]) ?>
                        <div class="col-sm-12">
                            <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger btn-flat',
                                'data' => [
                                    'confirm' => 'Deseja realmente apagar?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                            <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-flat']) ?>
                            <?= Html::a('Ir para Vendas PF', ['index'], ['class' => 'btn btn-primary btn-flat pull-right']);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-4 col-sm-offset-4">
    <?php
    echo Alert::widget([
        'options' => [
            'class' => 'alert-success',
        ],
        'body' => "Esta venda foi Realizada com sucesso!</br>". formatar($model->total)." foram adicionado ao caixa!",
    ]);
    ?>
</div>

