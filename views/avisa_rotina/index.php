<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Avisa_rotinaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Avisa Rotinas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="avisa-rotina-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Create Avisa Rotina', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
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
                'empresa_fk',
                'rotina_fk',
                'data_entrega',
                'status_chegada',
                // 'status_entrega',
                // 'data_chegada',
                // 'data_pronto',
                // 'data_entregue',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
