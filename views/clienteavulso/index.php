<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClienteavulsoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clienteavulsos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clienteavulso-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Cadastrar Cliente Avulso', ['create'], ['class' => 'btn btn-success']) ?>

    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            ['attribute' => 'cpf',
                'format' => 'html',
                'value' => function($model) {
                    return preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{2})$/', '${1}.${2}.${3}-${4}', $model->cpf);
                },
            ],

            'nome',
            //'telefone',
            //'numero',
            //'rua',
            //'bairro',
            //'cidade',
            //'cep',
            //'uf',
            //'rotina',
            //'datanascimento',
            //'usuario_fk',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
