<?php

use app\models\Usuario;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Compra */

$this->title = $model->descricao;
$this->params['breadcrumbs'][] = ['label' => 'Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
function quantidade($model){
    if($model>1){
        return "$model unidades";
    }
    return "$model unidade";
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

function usuario($model){
    $usuario = Usuario::find()->all();

    foreach ($usuario as $u){
        if ($u->id == $model){
            return $u->nome;
        }
    }
}

?>
<div class="compra-view box box-primary">
    <div class="box-header with-border">
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
    <div class="panel-body">
        <div class="panel-group collapse in">
            <div class="panel panel-default">
                <div class="panel-heading with-border col-sm-12">
                    <div class="col-sm-10">
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
                                        'value' => quantidade($model->quantidade),
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
                                        'format' => ['date', 'php: d/m/Y'],
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                    [
                                        'label' => 'Valor total',
                                        'value' =>  formatar($model->valor),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'label' => 'Usuário',
                                        'value' =>  usuario($model->usuario_fk),
                                        'labelColOptions' => ['style' => 'width:15%'],
                                        'valueColOptions' => ['style' => 'width:35%'],
                                    ],
                                ],
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
