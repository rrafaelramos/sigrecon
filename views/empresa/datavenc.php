<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmpresaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Empresas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresa-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Cadastrar Empresa', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
        <?= Html::a('Voltar', ['site/index'], ['class' => 'btn btn-warning btm-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
//                ['attribute' => 'cnpj',
//                    'format' => 'html',
//                    'value' => function($model) {
//                        return preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '${1}.${2}.${3}/${4}-${5}', $model->cnpj);
//                    },
//                ],
                'razao_social',
                //'nome_fantasia',
                //'email:email',
//                ['attribute' => 'telefone',
//                    'format' => 'html',
//                    'value' => function($model) {
//                        return preg_replace('/^(\d{2})(\d{4})(\d{4})$/', '(${1}) ${2}-${3}', $model->telefone);
//                    },
//                ],
                // 'celular',
                // 'numero',
                // 'complemento',
                // 'rua',
                // 'bairro',
                // 'cidade',
                // 'cep',
                // 'uf',
                // 'data_abertura',
                 [ 'attribute' => 'data_procuracao',
                    'format' => ['date','php:d/m/Y']
                 ],
                 ['attribute' => 'data_certificado',
                    'format' => ['date', 'php:d/m/Y'],
                 ],
                // 'rotina',
                'responsavel',
                // 'cpf_socio',
                // 'datanascimento_socio',
                // 'rg',
                // 'titulo',
                // 'nome_mae_socio',
                ['attribute' => 'telefone_socio',
                    'format' => 'html',
                    'value' => function($model) {
                        return preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->celular);
                    },
                ],
                // 'usuario_fk',

                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{view}{update}',
                ],

            ],
        ]); ?>
    </div>
</div>
