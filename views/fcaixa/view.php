<?php

use yii\bootstrap\Alert;
use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Fcaixa */

$this->title = "Fechar caixa ";
$this->params['breadcrumbs'][] = ['label' => 'Caixa'];
$this->params['breadcrumbs'][] = ['label' => 'Fechar'];
?>

<?php

if(!Yii::$app->user->isGuest && Yii::$app->user->identity->tipo == '1'){

    function formatar($model){
        $formatter = Yii::$app->formatter;
        if($model) {
            $formatado = $formatter->asDecimal($model);
            $valor = "R$ ".$formatado;
            return $valor;
        }else
            return 'R$ 0,00';
    }

    function formatarData($model){
        $dataf = explode(" ",$model->data_fechamento);

        $hora = $dataf[1];

        $aux = $dataf[0];
        $ano_ymd = explode("-",$aux);
        $ano = $ano_ymd[0];
        $mes = $ano_ymd[1];
        $dia = $ano_ymd[2];
        return "$dia/$mes/$ano às $hora";
    }

    ?>
    <div class="col-sm-12">
        <div class="col-sm-offset-2">
            <div class="clienteavulso-form col-sm-10">
                <div class="empresa-view box box-primary">
                    <div class="panel-body">
                        <div class="panel-group collapse in">
                            <div class="panel panel-default">
                                <div class="panel-heading with-border col-sm-12">
                                    <div class="col-sm-12">
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
                                                        'attribute' => 'data_fechamento',
                                                        'value' => formatarData($model),
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                ],
                                            ],
                                            [
                                                'columns' =>[
                                                    [
                                                        'attribute' => 'saida',
                                                        'label' => 'Saídas',
                                                        'value' => formatar($model->saida),
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                    [
                                                        'attribute' => 'entrada',
                                                        'label' => 'Entradas',
                                                        'value' => formatar($model->entrada),
                                                        'labelColOptions' => ['style' => 'width:15%'],
                                                        'valueColOptions' => ['style' => 'width:35%'],
                                                    ],
                                                ],
                                            ],
                                            [
                                                'columns' => [
                                                    [
                                                        'attribute' => 'saldo',
                                                        'label' => 'Saldo',
                                                        'value' => formatar($model->saldo),
                                                        'labelColOptions' => ['style' => 'width:35%'],
                                                        'valueColOptions' => ['style' => 'width:65%'],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ]) ?>
                                    <div>
                                        <?= Html::a('Finalizar', ['/site/index'],[ 'class' => 'btn btn-success btn-flat pull-right']) ?>

                                        <?php
                                        $data = $model->data_fechamento;
                                        ?>

                                        <?= Html::a('Vizualizar Relatório', ['relatorio_caixa/fechamento', 'data_fim' => $data],[ 'class' => 'btn btn-primary btn-flat pull-left']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } else{
    echo '<center><div class="col-sm-4 col-sm-offset-4">';
    echo Alert::widget([
        'options' => [
            'class' => 'alert-warning',
        ],
        'body' => 'Acesso negado! <br>Somente o Gerente possui acesso!',
    ]);
    echo Html::a(
        '<span class=""></span> Voltar',
        ['/site/index'],
        ['data-method' => 'post', 'class' => 'btn btn-success btn-flat']
    );
    echo '<center></div>';
}
?>