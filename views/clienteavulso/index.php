<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClienteavulsoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clienteavulsos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clienteavulso-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Cadastrar Cliente', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
        <?= Html::a('Voltar', ['site/index'], ['class' => 'btn btn-warning btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'responsive' => 'true',
            'resizableColumns'=>true,
            'hover' => 'true',
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                'cpf',
                'nome',
                'telefone',
                'numero',
                // 'rua',
                // 'bairro',
                // 'cidade',
                // 'cep',
                // 'uf',
                // 'rotina',
                // 'datanascimento',
                // 'usuario_fk',
                // 'complemento',

                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{view}{update}',
                ],
            ],
        ]); ?>
    </div>
</div>
