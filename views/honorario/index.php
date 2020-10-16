<?php

use app\models\Empresa;
use app\models\Usuario;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
/* @var $this yii\web\View */
/* @var $searchModel app\models\HonorarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Honorarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
function empresa($model){
    $empresa = Empresa::find()->all();
    foreach ($empresa as $e){
        if($e->id == $model->empresa_fk){
            return $e->razao_social;
        }
    }
}
function usuario($model){
    $usuario = Usuario::find()->all();
    foreach ($usuario as $u){
        if($u->id == $model->usuario_fk){
            return $u->nome;
        }
    }
}
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

<div class="honorario-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Novo +', ['create'], ['class' => 'btn btn-success btn-flat pull-left']) ?>
        <?= Html::a('Voltar', ['site/index'], ['class' => 'btn btn-primary btn-flat pull-right']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'hover' => 'true',
            'resizableColumns'=>'true',
            'responsive' => 'true',
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                //['class' => 'kartik\grid\SerialColumn'],
                //      'id',
                ['attribute' => 'empresa_fk',
                    'label' => 'Empresa',
                    'value' => function($model){
                        return empresa($model);
                    }
                ],
                ['attribute' => 'valor',
                    'value' => function($model){
                        return formatar($model->valor);
                    }
                ],
                ['attribute' => 'referencia',
                    'label' => 'Data de Referência',
                    'format' => ['date', 'php:m/Y' ],
                ],
                ['attribute' => 'data_pagamento',
                    'label' => 'Data de Pagamento',
                    'format' => ['date', 'php:d/m/Y' ],
                ],
                ['attribute' => 'usuario_fk',
                    'label' => 'Recebido por:',
                    'value' => function($model){
                        return usuario($model);
                    },
                ],
                //'usuario_fk',
                // 'observacao:ntext',
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{view}{update}',
                ]
            ],
        ]); ?>
    </div>
</div>
