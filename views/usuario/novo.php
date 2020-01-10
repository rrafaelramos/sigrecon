<?php

use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Meu Perfil'];
?>

<?php
    function tipo($model){
        if($model->tipo == 0){
            return 'Solicitação efetuada!';
        }elseif ($model->tipo == 1){
            return 'Gerente';
        }elseif ($model->tipo == 2){
            return 'Colaborador';
        }elseif($model->tipo == 3){
            return 'Recusado pelo Gerente!';
        }
    }
?>

<?php
echo Alert::widget([
    'options' => [
        'class' => 'alert-warning',
    ],
    'body' => 'Solicitação de cadastro efetuada!',
]);
?>
<div class="usuario-view box box-primary">
    <div class="box-header with-border">
        <div class="col-sm-10">
            <h4 class="panel-title">Dados do Usuário</h4>
        </div>
        <div>
            <div class="pull-right">
                <?= Html::a('Voltar', ['/site/index'], ['class' => 'btn btn-warning btn-flat']) ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel-group collapse in">
            <div class="panel panel-default">
                <div class="panel-heading with-border col-sm-12">
                    <div class="col-sm-8">
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
                                    //'id',
                                    [
                                        'attribute' => 'username',
                                        'label' => 'Usuário',
                                        'value' => $model->username,
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                    [
                                        'attribute' => 'nome',
                                        'value' => $model->nome,
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                ]
                            ],
                            [
                                'columns' => [
//                                    [
//                                        'attribute' => 'password',
//                                        'value' => 'teste',
//                                    ],
                                    [
                                        'attribute' => 'email:email',
                                        'label' => 'E-Mail',
                                        'value' => $model->email,
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                    [
                                        'attribute' => 'tipo',
                                        'value' => tipo($model),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                    //'authKey',
                                ],
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

