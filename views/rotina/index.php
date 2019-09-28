<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RotinaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rotinas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rotina-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Cadastrar Rotina', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nome',
            'repeticao',
            'doc_entrega',
            'doc_busca',
            //'data_entrega',
            //'data_aviso',
            //'informacao',
            //'msg_aviso',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
