<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
/* @var $this yii\web\View */
/* @var $model app\models\Fcaixa */

$this->title = "Fechamento: ".$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Caixa Fechados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
function formatar($model){
    if (!$model){
        return "R$ 0,00";
    }
    $formatter = Yii::$app->formatter;
    $formatado = $formatter->asCurrency($model);
    $dinheiro = str_replace("pt-br", "R$", $formatado);
    return $dinheiro;
}
?>
<div class="col-sm-12">
    <div class="col-sm-offset-2">
        <div class="clienteavulso-form col-sm-10">
            <div class="empresa-view box box-primary">
                <div class="panel-body">
                    <div class="panel-group collapse in">
                        <div class="panel panel-default">
                            <div class="panel-heading with-border col-sm-12">
                                <div class="col-sm-12">
                                    <h4>Dados Gerais</h4>
                                </div>
                            </div>

                            <div class="box-body table-responsive">
                                <?= DetailView::widget([
                                    'model' => $model,
                                    //'condensed' => true,
                                    'bordered' => true,
                                    'striped' => false,
                                    'enableEditMode' => false,
                                    'mode' => DetailView::MODE_VIEW,
                                    'attributes' => [
                                        [
                                            'columns' => [
                                                [
                                                    'attribute' => 'data_fechamento',
                                                    'value' => $model->data_fechamento,
                                                    'format' => ['date', 'php:d/m/Y'],
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                            ],
                                        ],
                                        [
                                            'columns' =>[
                                                [
                                                    'attribute' => 'saida',
                                                    'label' => 'Compras efetuadas',
                                                    'value' => formatar($model->saida),
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                                [
                                                    'attribute' => 'entrada',
                                                    'label' => 'Vendas realizadas',
                                                    'value' => formatar($model->entrada),
                                                    'labelColOptions' => ['style' => 'width:15%'],
                                                    'valueColOptions' => ['style' => 'width:35%'],
                                                ],
                                            ],
                                        ],
                                        [
                                            'columns' => [
                                                [
                                                    'attribute' => 'saldo',
                                                    'label' => 'Saldo',
                                                    'value' => formatar($model->saldo),
                                                    'labelColOptions' => ['style' => 'width:35%'],
                                                    'valueColOptions' => ['style' => 'width:65%'],
                                                ],
                                            ],
                                        ],
                                    ],
                                ]) ?>
                                <div>
                                    <?= Html::a('Início', ['/site/index'],[ 'class' => 'btn btn-warning btn-flat pull-right']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
