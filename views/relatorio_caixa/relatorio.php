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
                            <h4>Dados Gerais</h4>
                        </div>
                    </div>

                    <div class="box-body table-responsive">
                        <?php foreach ($models as $model) {
                            $data = explode(" ",$model->data);
                            echo $inicio;
                            echo "<br>$fim";
                            if (strtotime($inicio) <= strtotime($model->data) && strtotime($fim) >= strtotime($model->data)) {
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
                                                    'value' => Yii::$app->user->identity->nome,
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

                        <?= DetailView::widget([
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
                        ?>


                        <div class="pull-right">
                            <?= Html::a('Finalizar', ['/site/index'], ['class' => 'btn btn-primary btn-flat']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

