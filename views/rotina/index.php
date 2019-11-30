<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RotinaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rotinas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rotina-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Cadastrar Rotina', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
        <?= Html::a('Voltar', ['site/index'], ['class' => 'btn btn-warning btn-flat']) ?>
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
                'nome',
                ['attribute' => 'repeticao',
                    'value' => function($model){
                        if($model->repeticao == 1){
                            return 'Todo mês';
                        }elseif ($model->repeticao == 2){
                            return 'À cada Trimestre';
                        }elseif ($model->repeticao == 3){
                            return 'À cada semestre';
                        }elseif($model->repeticao == 4){
                            return 'Anualmente';
                        }
                    }],
                'doc_entrega',
                'doc_busca',
                ['attribute' => 'data_entrega',
                    'format' =>['date','php:d/m/Y']
                ],
                // 'data_aviso',
                // 'informacao',
                // 'msg_aviso',
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{view}{update}',
                ],
            ],
        ]); ?>
    </div>
</div>
