<?php

use app\models\Empresa;
use app\models\Rotina;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $model app\models\Avisa_rotina */

$this->title = rotina($model->rotina_fk);
$this->params['breadcrumbs'][] = ['label' => 'Avisa Rotinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
function empresa($model){
    $empresas = Empresa::find()->all();

    foreach ($empresas as $e){
        if($e->id == $model){
            return $e->razao_social;
        }
    }
}
function rotina($model){
    $rotinas = Rotina::find()->all();
    foreach ($rotinas as $r){
        if($r->id == $model){
            return $r->nome;
        }
    }
}
function chegada($model){
    if($model==0){
        return "Aguardando recebimento";
    }elseif($model==1){
        return "Recebido";
    }
}
function entrega($model){
    if($model==0){
        return "Pendente";
    }elseif ($model==1){
        return "Pronto para entrega";
    }else{
        return"Entregue";
    }
}
?>

<div class="clienteavulso-view box box-primary">
    <div class="box-header with-border">
        <div class="col-xs-10">
            <h4 class="panel-title">Dados da Rotina</h4>
        </div>
        <div>
            <div class="pull-right">
                <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-warning btn-flat']) ?>
                <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel-group collapse in">
            <div class="panel panel-default">
                <div class="panel-heading with-border col-xs-12">
                    <div class="col-xs-10">
                        <h2 class="panel-title">Rotina</h2>
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
                                        'label' => 'Empresa',
                                        'attribute' => 'empresa_fk',
                                        'value' =>  empresa($model->empresa_fk),
                                        'labelColOptions' => ['style' => 'width:25%'],
                                        'valueColOptions' => ['style' => 'width:75%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'label' => 'Rotina',
                                        'attribute' => 'rotina_fk',
                                        'value' =>  rotina($model->rotina_fk),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                    [
                                        'label' => 'Data entrega',
                                        'attribute' => 'data_entrega',
                                        'format' => ['date', 'php: d/m/Y'],
                                        'value' =>  $model->data_entrega,
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'label' => 'Status chegada',
                                        'attribute' => 'status_chegada',
                                        'value' =>  chegada($model->status_chegada),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                    [
                                        'label' => 'Status entrega',
                                        'attribute' => 'status_entrega',
                                        'value' =>  entrega($model->status_entrega),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'label' => 'Data chegada',
                                        'attribute' => 'data_chegada',
                                        'value' =>  $model->data_chegada,
                                        'format' => ['date', 'php: d/m/Y'],
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                    [
                                        'label' => 'Data Pronto',
                                        'attribute' => 'data_pronto',
                                        'value' =>  $model->data_pronto,
                                        'format' => ['date', 'php: d/m/Y'],
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'label' => 'Data entregue',
                                        'attribute' => 'data_entregue',
                                        'value' =>  $model->data_entregue,
                                        'format' => ['date', 'php: d/m/Y'],
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
