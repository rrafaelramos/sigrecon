<?php

use app\models\Rotina;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClienteavulsoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clientes';
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
                'nome',
                ['attribute' => 'cpf',
                    'format' => 'html',
                    'value' => function($model) {
                        return preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{2})$/', '${1}.${2}.${3}-${4}', $model->cpf);
                    },
                ],
                ['attribute' => 'telefone',
                    'format' => 'html',
                    'value' => function($model) {
                        return preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->telefone);
                    },
                ],
                ['attribute' => 'rotina',
                    'value' => function($model){
                        //retorna todos as rotinas cadastradas para $rotina
                        $rotina = Rotina::find()->all();
                        foreach ($rotina as $a){
                            if($a->id == $model->rotina){
                                return "$a->nome";
                            }
                        }
                    }],
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
