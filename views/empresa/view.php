<?php

use app\models\Rotina;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $model app\models\Empresa */
/* @var $rotina_empresa app\models\Rotina_empresa */


$this->title = $model->razao_social;
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="empresa-view box box-primary">
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
            <?php
            //Busca todas as rotinas cadastradas e guarda para $rotina,
            $rotina = Rotina::find()->all();
            foreach ($rotina as $r){
                if($model->rotina == $r->id){
                    $rotina = $r->nome;
                }
            }

            date_default_timezone_set('America/Sao_Paulo');
            ?>
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
                                            'label' => 'Nome Fantasia',
                                            'value' => $model->nome_fantasia,
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
                                            'label' => 'Email',
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
                                        [
                                            'attribute' => 'celular',
                                            'value' => preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->celular),
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
                            <h4>Dados do Sócio Administrador</h4>
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
                                        [
                                            'label' => 'Rotina',
                                            'value' => $rotina,
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
                                            'label' => 'Data de Abertura',
                                            'value' => $model->data_abertura,
                                            'format' => ['date', 'php:d/m/Y'],
                                            'labelColOptions' => ['style' => 'width:10%'],
                                            'valueColOptions' => ['style' => 'width:15%'],
                                        ],
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
