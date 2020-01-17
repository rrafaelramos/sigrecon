<?php

use app\models\Usuario;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Mensagem */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Recados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
function emissor($model){
    $usuarios = Usuario::find()->all();
    foreach ($usuarios as $u){
        if ($u->id == $model->emissor){
            return $u->nome;
        }
    }
}

function receptor($model){
    $usuarios = Usuario::find()->all();
    foreach ($usuarios as $u){
        if ($u->id == $model->receptor){
            return $u->nome;
        }
    }
}

function lido($model){
    if($model->lido == 1){
        return 'Sim';
    }
    return 'Não';
}
?>
    <div class="usuario-view box box-primary">
        <div class="box-header with-border">
            <div class="col-sm-10">
                <h4 class="panel-title"><?php echo '"'.$model->titulo.'"'?></h4>
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
                    <div class="panel-heading with-border col-sm-12">
                        <div class="col-sm-8">
                            <h2 class="panel-title"><?php echo 'De '.emissor($model).' para: '.receptor($model) ?></h2>
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
//                            [
//                                'columns' => [
//                                    [
//                                        'label' => 'Emissor',
//                                        'value' =>  emissor($model),
//                                        'labelColOptions' => ['style' => 'width:15%'],
//                                        'valueColOptions' => ['style' => 'width:35%'],
//                                    ],
//                                    [
//                                        'label' => 'Receptor',
//                                        'value' =>  receptor($model),
//                                        'labelColOptions' => ['style' => 'width:15%'],
//                                        'valueColOptions' => ['style' => 'width:35%'],
//                                    ],
//                                ],
//                            ],
                                [
                                    'columns' => [

                                        [
                                            'label' => 'Recado:',
                                            'value' =>  $model->conteudo,
                                            'labelColOptions' => ['style' => 'width:15%'],
                                            'valueColOptions' => ['style' => 'width:85%'],
                                        ],

                                    ],
                                ],
                                [
                                    'columns' => [
                                        [
                                            'label' => 'Data de Envio:',
                                            'attribute' => 'data_envio',
                                            'format' => ['date','php: d/m/Y'],
                                            'value' => $model->data_envio,
                                            'labelColOptions' => ['style' => 'width:15%'],
                                            'valueColOptions' => ['style' => 'width:35%'],
                                        ],
                                        [
                                            'label' => 'Lido:',
                                            'value' =>  lido($model),
                                            'labelColOptions' => ['style' => 'width:15%'],
                                            'valueColOptions' => ['style' => 'width:35%'],
                                        ],
                                    ]
                                ]
//                            'id',
//                            //'emissor',
//                            //'receptor',
//                            //'data_envio',
//                            'titulo',
//                            //'conteudo:ntext',
//                            'lido',

                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>





<?= Html::a('Voltar', ['index'], ['class' => 'btn btn-warning btn-flat']) ?>
<?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
<?= Html::a('Apagar', ['delete', 'id' => $model->id], [
    'class' => 'btn btn-danger btn-flat',
    'data' => [
        'confirm' => 'Deseja realmente apagar?',
        'method' => 'post',
    ],
]) ?>