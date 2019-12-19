<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Compra */

$this->title = $model->descricao;
$this->params['breadcrumbs'][] = ['label' => 'Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clienteavulso-view box box-primary">
    <div class="box-header with-border">
        <div class="col-xs-10">
            <h4 class="panel-title">Dados da Compra</h4>
        </div>
        <div>
            <div class="pull-right">
                <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-warning btn-flat']) ?>
                <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
                <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger btn-flat',
                    'data' => [
                        'confirm' => 'Deseja realmente apagar?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div>
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
                    <?= \kartik\detail\DetailView::widget([
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
                                        'label' => 'Descrição',
                                        'value' =>  $model->descricao,
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                    [
                                        'label' => 'Quantidade',
                                        'value' =>  $model->quantidade,
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
//                                    [
//                                        'label' => 'ID',
//                                        'value' =>  $model->id,
//                                        'labelColOptions' => ['style' => 'width:15%'],
//                                        'valueColOptions' => ['style' => 'width:35%'],
//                                    ],
                                    [
                                        'label' => 'Data',
                                        'value' =>  $model->data,
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                    [
                                        'label' => 'Valor total',
                                        'value' =>  $model->valor,
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'label' => 'Usuário',
                                        'value' =>  $model->usuario_fk,
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                ],
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
