<?php

use app\models\Rotina;
use app\models\RotinaSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Clienteavulso */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="clienteavulso-view box box-primary">
    <div class="box-header with-border">
        <div class="col-xs-10">
            <h4 class="panel-title">Dados do(a) Cliente</h4>
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
                        <h2 class="panel-title">Dados Pessoais</h2>
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
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:85%'],
                                    ],
                                ],
                            ],
                        [
                            'columns' => [
                                [
                                    'label' => 'CPF',
                                    'value' => preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{2})$/', '${1}.${2}.${3}-${4}', $model->cpf),
                                    'labelColOptions' => ['style' => 'width:15%'],
                                    'valueColOptions' => ['style' => 'width:85%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'label' => 'Data de Nascimento',
                                    'format' => ['date', 'php:d/m/Y'],
                                    'value' => $model->datanascimento,
                                    'labelColOptions' => ['style' => 'width:15%'],
                                    'valueColOptions' => ['style' => 'width:35%'],
                                ],
                                [
                                    'label' => 'Telefone',
                                    'value' => preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->telefone),
                                    'labelColOptions' => ['style' => 'width:15%'],
                                    'valueColOptions' => ['style' => 'width:35%'],
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
                <div class="panel-heading with-border col-xs-12">
                    <div class="col-xs-10">
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
                                        'labelColOptions' => ['style' => 'width:10%'],
                                        'valueColOptions' => ['style' => 'width:25%'],
                                    ],
                                    [
                                        'label' => 'Bairro',
                                        'value' => $model->bairro,
                                        'labelColOptions' => ['style' => 'width:10%'],
                                        'valueColOptions' => ['style' => 'width:25%'],
                                    ],
                                    [
                                        'label' => 'Número',
                                        'value' => $model->numero,
                                        'labelColOptions' => ['style' => 'width:10%'],
                                        'valueColOptions' => ['style' => 'width:20%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'label' => 'Cidade',
                                        'value' => $model->cidade,
                                        'labelColOptions' => ['style' => 'width:10%'],
                                        'valueColOptions' => ['style' => 'width:15%'],
                                    ],
                                    [
                                        'attribute' => 'CEP',
                                        'label' => 'CEP',
                                        'value' => preg_replace('/^(\d{2})(\d{3})(\d{3})$/', '${1}.${2}-${3}', $model->cep),
                                        'labelColOptions' => ['style' => 'width:10%'],
                                        'valueColOptions' => ['style' => 'width:10%'],
                                    ],
                                    [
                                        'label' => 'Complemento',
                                        'value' => $model->complemento,
                                        'labelColOptions' => ['style' => 'width:10%'],
                                        'valueColOptions' => ['style' => 'width:15%'],
                                    ],
                                    [
                                        'label' => 'UF',
                                        'value' => $model->uf,
                                        'labelColOptions' => ['style' => 'width:10%'],
                                        'valueColOptions' => ['style' => 'width:20%'],
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

