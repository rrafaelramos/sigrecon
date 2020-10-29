<?php

use app\models\Empresa;
use app\models\Usuario;
use yii\helpers\Html;
use kartik\detail\DetailView;
/* @var $this yii\web\View */
/* @var $model app\models\Honorario */

$this->title = 'Lançar Honorário';
$this->params['breadcrumbs'][] = ['label' => 'Caixa'];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
function usuario($model){
    $usuario = Usuario::find()->all();
    foreach ($usuario as $u){
        if ($u->id == $model){
            return $u->nome;
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

function formatar($model){
    $formatter = Yii::$app->formatter;
    if($model) {
        $formatado = $formatter->asDecimal($model, 2);
        $valor = "R$ ".$formatado;
        return $valor;
    }else
        return 'R$ 0,00';
}

?>

<div class="honorario-view box box-primary">
    <div class="box-header with-border">
        <div class="col-sm-8">
            <h4 class="panel-title"></h4>
        </div>
        <div>
            <div class="col-sm-12">
<!--                JavaScript: window.history.back();-->
                <?= Html::a('Voltar para Honorários', ['index'], ['class' => 'btn btn-warning btn-flat pull-left']) ?>
                <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat pull-right']) ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel-group collapse in">
            <div class="panel panel-default">
                <div class="panel-heading with-border col-sm-12">
                    <div class="col-sm-8">
                        <h2 class="panel-title">Honorário</h2>
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
                            //'id',
                            [
                                'columns' => [
                                    ['attribute' => 'empresa_fk',
                                        'label' => 'Empresa',
                                        'value' => empresa($model),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                    ['attribute' => 'valor',
                                        'label' => 'Valor Pago',
                                        'value' => formatar($model->valor),
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
                                        'value' => usuario($model->usuario_fk),
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
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
