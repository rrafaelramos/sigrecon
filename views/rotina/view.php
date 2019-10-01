<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Rotina */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Rotinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rotina-view box box-primary">
    <div class="box-header">
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Deseja realmente apagar este item?',
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
                'repeticao',
                'doc_entrega',
                'doc_busca',
                ['attribute' => 'data_entrega',
                    'format' => ['date', 'php:d/m/Y'],
                ],
                ['attribute' => 'data_aviso',
                    'format' => ['date', 'php:d/m/Y'],
                ],
                'informacao',
                'msg_aviso',
            ],
        ]) ?>
    </div>
</div>
