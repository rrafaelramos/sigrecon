<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Clienteavulso */

$this->title = 'Contabilidade';
?>
<div class="clienteavulso-view box box-primary">
    <div class="box-header with-border">
        <div>
            <div class="col-sm-12">
                <?= Html::a('Sair', ['site/index'], ['class' => 'btn btn-primary btn-flat pull-right']) ?>
                <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-flat']) ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel-group collapse in">
            <div class="panel panel-default">
                <div class="panel-heading with-border col-sm-12">
                    <div class="col-sm-10">
                        <h2 class="panel-title">Contabilidade</h2>
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
                            //id
                            [
                                'columns' => [
                                    [
                                        'label' => 'Nome',
                                        'value' => $model->nome,
                                        'labelColOptions' => ['style' => 'width:20%'],
                                        'valueColOptions' => ['style' => 'width:30%'],
                                    ],
                                    [
                                        'label' => 'CNPJ',
                                        'value' => $model->cnpj,
                                        'labelColOptions' => ['style' => 'width:20%'],
                                        'valueColOptions' => ['style' => 'width:30%'],
                                    ],
                                    [
                                        'label' => 'Telefone',
                                        'value' => preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->telefone),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'label' => 'Gerente Reponsável',
                                        'value' => $model->responsavel,
                                        'labelColOptions' => ['style' => 'width:20%'],
                                        'valueColOptions' => ['style' => 'width:30%'],
                                    ],
                                    [
                                        'label' => 'CRC',
                                        'value' => $model->crc,
                                        'labelColOptions' => ['style' => 'width:20%'],
                                        'valueColOptions' => ['style' => 'width:30%'],
                                    ],
                                ],
                            ],
                        ],
                    ])?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel-group collapse in">
            <div class="panel panel-default">
                <div class="panel-heading with-border col-sm-12">
                    <div class="col-sm-10">
                        <h4>Endereço</h4>
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
                                        'label' => 'Logradouro',
                                        'value' => $model->rua,
                                        'labelColOptions' => ['style' => 'width:20%'],
                                        'valueColOptions' => ['style' => 'width:30%'],
                                    ],
                                    [
                                        'label' => 'Bairro',
                                        'value' => $model->bairro,
                                        'labelColOptions' => ['style' => 'width:20%'],
                                        'valueColOptions' => ['style' => 'width:30%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'label' => 'Número',
                                        'value' => $model->numero,
                                        'labelColOptions' => ['style' => 'width:20%'],
                                        'valueColOptions' => ['style' => 'width:30%'],
                                    ],
                                    [
                                        'label' => 'Cidade',
                                        'value' => $model->cidade,
                                        'labelColOptions' => ['style' => 'width:20%'],
                                        'valueColOptions' => ['style' => 'width:30%'],
                                    ],
                                ],
                            ],
                        ],
                    ])?>
                </div>
            </div>
        </div>
    </div>
</div>