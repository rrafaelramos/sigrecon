<?php

use yii\helpers\Html;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\HonorarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Honorarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="honorario-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Create Honorario', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'valor',
                'data_pagamento',
                'referencia',
                'usuario_fk',
                // 'empresa_fk',
                // 'observacao:ntext',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
