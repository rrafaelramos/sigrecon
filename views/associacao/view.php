<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Associacao */

$this->title = $model->razao_social;
$this->params['breadcrumbs'][] = ['label' => 'Associações', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="associacao-view box box-primary">
    <div class="box-header with-border">
        <div>
            <div class="col-sm-12">
                <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-primary btn-flat pull-right']) ?>
                <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-flat']) ?>
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
                <div class="panel-heading with-border col-sm-12">
                    <div class="col-sm-10">
                        <h4>Dados Gerais</h4>
                    </div>
                </div>

                <div class="box-body table-responsive">
                    <?= \kartik\detail\DetailView::widget([
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
                                        'label' => 'Razão Social',
                                        'value' => $model->razao_social,
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:85%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'attribute' => 'cnpj',
                                        'value' => preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '${1}.${2}.${3}/${4}-${5}', $model->cnpj),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],

                                    ],
                                    [
                                        'label' => 'e-Mail',
                                        'value' => $model->email,
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:85%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'attribute' => 'telefone',
                                        'value' => preg_replace('/^(\d{2})(\d{4})(\d{4})$/', '(${1}) ${2}-${3}', $model->telefone),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],

                                    ],
//                                    [
//                                        'attribute' => 'celular',
//                                        'value' => preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->celular),
//                                        'labelColOptions' => ['style' => 'width:15%'],
//                                        'valueColOptions' => ['style' => 'width:35%'],
//                                    ],
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

    <div class="panel-body">
        <div class="panel-group collapse in">
            <div class="panel panel-default">
                <div class="panel-heading with-border col-sm-12">
                    <div class="col-sm-10">
                        <h4>Dados do Presidente</h4>
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
                                        'label' => 'Nome',
                                        'value' => $model->responsavel,
                                        'labelColOptions' => ['style' => 'width:10%'],
                                        'valueColOptions' => ['style' => 'width:40%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'label' => 'Nome da Mãe',
                                        'value' => $model->nome_mae_socio,
                                        'labelColOptions' => ['style' => 'width:10%'],
                                        'valueColOptions' => ['style' => 'width:40%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'attribute' => 'cpf_socio',
                                        'label' => 'CPF',
                                        'value' => preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{2})$/', '${1}.${2}.${3}-${4}', $model->cpf_socio),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                    [
                                        'label' => 'RG',
                                        'value' => $model->rg,
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'label' => 'Título de Eleitor',
                                        'value' => $model->titulo,
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],

                                    [
                                        'label' => 'Data de Nascimento',
                                        'value' => $model->datanascimento_socio,
                                        'format' => ['date', 'php:d/m/Y'],
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'attribute' => 'telefone_socio',
                                        'value' => preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->telefone_socio),
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
                <div class="panel-heading with-border col-sm-12">
                    <div class="col-sm-10">
                        <h4>Informações adicionais</h4>
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
                                        'label' => 'Vencimento da Procuração',
                                        'value' => $model->data_procuracao,
                                        'format' => ['date', 'php:d/m/Y'],
                                        'labelColOptions' => ['style' => 'width:10%'],
                                        'valueColOptions' => ['style' => 'width:15%'],
                                    ],
                                    [
                                        'label' => 'Vencimento Certificado',
                                        'value' => $model->data_certificado,
                                        'format' => ['date', 'php:d/m/Y'],
                                        'labelColOptions' => ['style' => 'width:10%'],
                                        'valueColOptions' => ['style' => 'width:15%'],
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
