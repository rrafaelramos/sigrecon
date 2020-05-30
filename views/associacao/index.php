<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AssociacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Associações';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresa-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Novo +', ['create'], ['class' => 'btn btn-success btn-flat pull-left']) ?>
        <?= Html::a('Voltar', ['site/index'], ['class' => 'btn btn-primary btn-flat pull-right']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= \kartik\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'hover' => 'true',
            'resizableColumns'=>'true',
            'responsive' => 'true',
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                ['attribute' => 'cnpj',
                    'format' => 'html',
                    'value' => function($model) {
                        return preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '${1}.${2}.${3}/${4}-${5}', $model->cnpj);
                    },
                ],
                'razao_social',
                'email:email',
                //'telefone',
                // 'rua',
                // 'numero',
                // 'bairro',
                // 'cidade',
                // 'complemento',
                // 'cep',
                // 'uf',
                // 'data_procuracao',
                // 'data_certificado',
                // 'responsavel',
                // 'cpf_socio',
                // 'datanascimento_socio',
                // 'rg',
                // 'titulo',
                // 'nome_mae_socio',
                ['attribute' => 'telefone_socio',
                    'format' => 'html',
                    'value' => function($model) {
                        return preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->telefone_socio);
                    },
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
