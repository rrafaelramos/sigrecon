<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\icons\Icon;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ServicoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Serviços';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servico-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Cadastrar Serviço', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
        <?= Html::a('Voltar', ['site/index'], ['class' => 'btn btn-warning btn-flat'])?>
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
                'id',
                'descricao',
                'valor',
                'valor_minimo',
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{view}{update}',
                ],
            ],
        ]); ?>
    </div>
</div>
