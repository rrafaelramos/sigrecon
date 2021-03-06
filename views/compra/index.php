<?php

use app\models\Usuario;
use yii\base\Model;
use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CompraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Despesas';
$this->params['breadcrumbs'][] = $this->title;

function formatar($model){
    $formatter = Yii::$app->formatter;
    if($model) {
        $formatado = $formatter->asDecimal($model,2);
        $valor = "R$ ".$formatado;
        return $valor;
    }else
        return 'R$ 0,00';
}

function usuario($model){
    $usuario = Usuario::find()->all();

    foreach ($usuario as $u){
        if ($u->id == $model->usuario_fk){
            return $u->nome;
        }
    }
}

function unidade($model){
    if($model->quantidade>1){
        return "$model->quantidade unidades";
    }
    return "$model->quantidade unidade";
}
?>

<div class="servico-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Compra +', ['create'], ['class' => 'btn btn-warning btn-flat']); ?>
        <?= Html::a('Despesa +', ['compra/saida'], ['class' => 'btn btn-info btn-flat']) ?>
        <?= Html::a('Início', ['site/index'], ['class' => 'btn btn-primary btn-flat pull-right']) ?>
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
                //['class' => 'yii\grid\SerialColumn'],
                //'id',
                ['attribute' => 'descricao',
                    'label' => 'Descrição'],
                ['attribute' => 'usuario_fk',
                    'label' => 'Comprado por',
                    'value' => function($model){
                        return usuario($model);
                    }],
                ['attribute' => 'quantidade',
                    'value' => function($model){
                        return unidade($model);
                    }],
                ['attribute' => 'data',
                    'label' => 'Data da Compra',
                    'format' => ['date','php:d/m/Y']
                ],
                ['attribute' => 'valor',
                    'label' => 'Valor Total',
                    'value' => function($model){
                        return formatar($model->valor);
                    }],
                ['class' => 'yii\grid\ActionColumn', 'template' => '{view}{delete}'],
            ],
        ]); ?>
    </div>
</div>
