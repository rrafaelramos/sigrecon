<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Rotina */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Rotinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="rotina-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Deseja realmente apagar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
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
