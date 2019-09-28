<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Empresa */

$this->title = $model->razao_social;
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="empresa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Deseja realmente excluir?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'cnpj',
            'razao_social',
            'nome_fantasia',
            'email:email',
            'telefone',
            'celular',
            'numero',
            'complemento',
            'rua',
            'bairro',
            'cidade',
            'cep',
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
            'cpf_socio',
            ['attribute' => 'datanascimento_socio',
                'format' => ['date', 'php:d/m/Y'],
            ],
            'rg',
            'titulo',
            'nome_mae_socio',
            'telefone_socio',
            //'usuario_fk',
        ],
    ]) ?>

</div>
