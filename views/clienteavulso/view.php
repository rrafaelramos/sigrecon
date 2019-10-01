<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Clienteavulso */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clienteavulso-view box box-primary">
    <div class="box-header">
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Deseja realmente excluir?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
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
                'rua',
                'numero',
                'complemento',
                'bairro',
                'cidade',
                ['attribute' => 'cep',
                    'format' => 'html',
                    'value' => function($model) {
                        return preg_replace('/^(\d{2})(\d{3})(\d{3})$/', '${1}.${2}-${3}', $model->cep);
                    },
                ],
                'uf',
                'rotina',
                ['attribute' => 'datanascimento',
                    'format' => ['date', 'php:d/m/Y'],
                ],
                'usuario_fk',
            ],
        ]) ?>
    </div>
</div>
