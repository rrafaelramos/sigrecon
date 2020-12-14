<?php

use app\models\Usuario;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MensagemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recados';
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
?>

<div class="mensagem-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Novo +', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
        <?= Html::a('Voltar', ['site/index'], ['class' => 'btn btn-warning btn-flat']) ?>
        <?= Html::a('Enviadas', ['enviadas'], ['class' => 'btn btn-primary btn-flat pull-right']) ?>

    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= \kartik\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'hover' => 'true',
            'resizableColumns'=>'true',
            'responsive' => 'true',
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                //               ['class' => 'yii\grid\SerialColumn'],

                //'id',
                ['attribute' => 'emissor',
                    'value' => function($model){
                        return emissor($model);
                    }
                ],
                ['attribute' => 'receptor',
                    'value' => function($model){
                        return receptor($model);
                    }],
                ['attribute' => 'data_envio',
                    'format' => ['date', 'php: d/m/Y']
                ],
                'titulo',
                // 'conteudo:ntext',
                // 'empresa_fk',
                // 'servico_fk',
                ['attribute' => 'lido',
                    'value' => function($model){
                        if($model->lido=='1'){
                            return 'Sim';
                        }else{
                            return 'Não';
                        }
                    },
                    'label' => 'Lido',
                ],

                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{view}',
                ],
            ],
        ]); ?>
    </div>
</div>
