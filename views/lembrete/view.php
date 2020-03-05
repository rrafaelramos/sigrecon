<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Lembrete */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lembretes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lembrete-view box box-primary">
    <div class="box-header">
        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat pull-left',
            'data' => [
                'confirm' => 'Deseja realmente apagar?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat pull-right']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                [
                    'attribute'=> 'data',
                    'format' => ['date', 'php:d/m/Y']
                ],
                'titulo',
                [
                    'attribute'=> 'usuario_fk',
                    'value' => Yii::$app->user->identity->nome,
                ],
            ],
        ]) ?>
    </div>
</div>
