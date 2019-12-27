<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Avisa_rotina */

$this->title = 'Update Avisa Rotina: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Avisa Rotinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="avisa-rotina-update">

    <?= $this->render('_formEditar', [
        'model' => $model,
    ]) ?>

</div>
