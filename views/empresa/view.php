<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Empresa */

$this->title = $model->razao_social;
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresa-view box box-primary">
    <div class="box-header">
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Deseja realmente apagar?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                'razao_social',
                ['attribute' => 'cnpj',
                    'format' => 'html',
                    'value' => function($model) {
                        return preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '${1}.${2}.${3}/${4}-${5}', $model->cnpj);
                    },
                ],
                'nome_fantasia',
                'email:email',
                ['attribute' => 'telefone',
                    'format' => 'html',
                    'value' => function($model) {
                        return preg_replace('/^(\d{2})(\d{4})(\d{4})$/', '(${1}) ${2}-${3}', $model->telefone);
                    },
                ],
                ['attribute' => 'celular',
                    'format' => 'html',
                    'value' => function($model) {
                        return preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->celular);
                    },
                ],
                'numero',
                'complemento',
                'rua',
                'bairro',
                'cidade',
                ['attribute' => 'cep',
                    'format' => 'html',
                    'value' => function($model) {
                        return preg_replace('/^(\d{2})(\d{3})(\d{3})$/', '${1}.${2}-${3}', $model->cep);
                    },
                ],
                'uf',
                ['attribute' => 'data_abertura',
                    'format' => ['date', 'php:d/m/Y'],
                ],
                ['attribute' => 'data_procuracao',
                    'format' => ['date', 'php:d/m/Y'],
                ],
                ['attribute' => 'data_certificado',
                    'format' => ['date', 'php:d/m/Y'],
                ],
                'rotina',
                'responsavel',
                ['attribute' => 'cpf_socio',
                    'format' => 'html',
                    'value' => function($model) {
                        return preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{2})$/', '${1}.${2}.${3}-${4}', $model->cpf_socio);
                    },
                ],
                ['attribute' => 'datanascimento_socio',
                    'format' => ['date', 'php:d/m/Y'],
                ],
                'rg',
                'titulo',
                'nome_mae_socio',
                ['attribute' => 'telefone_socio',
                    'format' => 'html',
                    'value' => function($model) {
                        return preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->celular);
                    },
                ],

                'usuario_fk',
            ],
        ]) ?>
    </div>
</div>
