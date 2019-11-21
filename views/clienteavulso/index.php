<?php

use app\models\Rotina;
use app\models\RotinaSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClienteavulsoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;

$aux = new RotinaSearch();



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
                ['attribute' => 'cpf',
                    'format' => 'html',
                    'value' => function($model) {
                        return preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{2})$/', '${1}.${2}.${3}-${4}', $model->cpf);
                    },
                ],
                'nome',
                ['attribute' => 'telefone',
                    'format' => 'html',
                    'value' => function($model) {
                        return preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->telefone);
                    },
                ],
//                ['attribute' => 'rotina',
//                    'value' => $userQuery = (new Query())->select('nome')->from('rotina')->where($model->rotina == 'id')
//                ],
                //'numero',
                // 'rua',
                // 'bairro',
                // 'cidade',
                // 'cep',
                // 'uf',
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
