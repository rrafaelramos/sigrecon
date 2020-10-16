<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Servico */

$this->title = $model->descricao;
$this->params['breadcrumbs'][] = ['label' => 'Serviços', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php

    function formatar($model){
        $formatter = Yii::$app->formatter;
        if($model) {
            $formatado = $formatter->asDecimal($model);
            $valor = "R$ ".$formatado;
            return $valor;
        }else
        return 'R$ 0,00';
    }
?>

<div class="col-sm-12">
    <div class="col-sm-offset-3">
        <div class="clienteavulso-form col-sm-7">
            <div class="empresa-view box box-primary">
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
                                    //'condensed' => true,
                                    'bordered' => true,
                                    'striped' => false,
                                    'enableEditMode' => false,
                                    'mode' => DetailView::MODE_VIEW,
                                    'attributes' => [
                                        [
                                            'columns' => [
                                                [
                                                    'attribute' => 'descricao',
                                                    'value' => $model->descricao,
                                                    'labelColOptions' => ['style' => 'width:35%'],
                                                    'valueColOptions' => ['style' => 'width:65%'],
                                                ],
//                                                [
//                                                    'attribute' => 'id',
//                                                    'value' => $model->id,
//                                                    'labelColOptions' => ['style' => 'width:15%'],
//                                                    'valueColOptions' => ['style' => 'width:35%'],
//                                                ],
                                            ],
                                        ],
                                        [
                                            'columns' => [
                                                [
                                                    'attribute' => 'valor',
                                                    'value' => formatar($model->valor),
                                                    'labelColOptions' => ['style' => 'width:17%'],
                                                    'valueColOptions' => ['style' => 'width:33%'],
                                                ],
                                                [
                                                    'attribute' => 'valor_minimo',
                                                    'label' => 'Mínimo',
                                                    'value' => formatar($model->valor_minimo),
                                                    'labelColOptions' => ['style' => 'width:17%'],
                                                    'valueColOptions' => ['style' => 'width:33%'],
                                                ],
                                            ],
                                        ],
                                    ],
                                ]) ?>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="col-sm-12">
                            <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-flat']) ?>
                            <?= Html::a('Finalizar', ['index'], ['class' => 'btn btn-primary btn-flat pull-right']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
