<?php

use yii\helpers\Html;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FcaixaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fcaixas';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
function formatar($model){
    if(!$model){
        return "R$ 0,00";
    }
    $formatter = Yii::$app->formatter;
    $formatado = $formatter->asCurrency($model);
    //$remove = array("pt-br");
    $dinheiro = str_replace("pt-br", "", $formatado);
    return "R$ $dinheiro";
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
<div class="fcaixa-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Início', ['/site/index'], ['class' => 'btn btn-primary btn-flat pull-right']) ?>
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
                ['class' => 'yii\grid\SerialColumn'],
                //'id',

                ['attribute' => 'data_fechamento',
                    'label' => 'Data Fechamento',
                    'value' => function($model){
                        return formatarData($model);
                    },
                ],
                ['attribute' => 'entrada',
                    'label' => 'Total de Entrada (+)',
                    'value' => function($model){
                        return formatar($model->entrada);
                    }
                ],['attribute' => 'saida',
                    'label' => 'Total de Saída (-)',
                    'value' => function($model){
                        return formatar($model->saida);
                    }
                ],
                ['attribute' => 'saldo',
                    'label' => 'Saldo',
                    'value' => function($model){
                        return formatar($model->saldo);
                    }
                ],
                ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
            ],
        ]); ?>
    </div>
</div>
