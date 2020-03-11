<?php

use app\models\Clienteavulso;
use app\models\Servico;
use app\models\Usuario;
use yii\helpers\Html;
use kartik\grid\GridView;



$this->title = 'Vendas PF';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
function cliente($model){
    $cliente = Clienteavulso::find()->all();
    foreach ($cliente as $c){
        if($c->id == $model->cliente_fk){
            return $c->nome;
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

function servico($model){
    $servico = Servico::find()->all();
    foreach ($servico as $s){
        if($s->id == $model->servico_fk){
            return $s->descricao;
        }
    }
}

function formatar($model){

    if(!$model){
        return "R$ 0,00";
    }
    $formatter = Yii::$app->formatter;
    $formatado = $formatter->asCurrency($model);
    $dinheiro = str_replace("pt-br", "", $formatado);
    return "R$ $dinheiro";
}
?>
<div class="servico-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Voltar', ['site/index'], ['class' => 'btn btn-primary btn-flat pull-right'])?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'hover' => 'true',
            'resizableColumns'=>'true',
            'responsive' => 'true',
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],
//                ['attribute' => 'id',
//                    'label' => 'N° da Venda',
//                ],
//                ['attribute' => 'data',
//                    'format' => ['date','php:d/m/Y']
//                ],
                // 'data',
                ['attribute' =>'cliente_fk',
                    'label' => 'Cliente',
                    'value' => function($model){
                        return cliente($model);
                    }],
                ['attribute' => 'usuario_fk',
                    'label' => 'Vendedor',
                    'value' => function($model){
                        return usuario($model);
                    }],
                ['attribute' => 'servico_fk',
                    'value' => function($model){
                        return servico($model);
                    }],
                // 'quantidade',
//                [
//                    'attribute' => 'total',
//                    'value' => function($model){
//                        return formatar($model->total);
//                    }],

                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{update}',
                ],
            ],
        ]); ?>
    </div>
</div>