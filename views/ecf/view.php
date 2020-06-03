<?php

use app\models\Associacao;
use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ecf */

$this->title = 'ECF';
$this->params['breadcrumbs'][] = ['label' => 'ECF', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

function buscacnpj($associacao_id){
    $asso = Associacao::find()->all();
    foreach ($asso as $assoc){
        if ($assoc->id == $associacao_id){
            return $assoc->cnpj;
        }
    }
}

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
                                        'label' => 'Nome',
                                        'value' => $model->associacao_nome,
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:85%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'label' => 'Presidente',
                                        'value' => $model->presidente,
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                    [
                                        'attribute' => 'fone_presidente',
                                        'value' => preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->fone_presidente),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'attribute' => 'cnpj',
                                        'label' => 'CNPJ',
                                        'value' => preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '${1}.${2}.${3}/${4}-${5}', buscacnpj($model->associacao_id)),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],

                                    ],
                                    [
                                        'label' => 'Feito',
                                        'value' => $model->feito,
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:85%'],
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
