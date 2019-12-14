<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Alertaservico */

$this->title = 'Update Alertaservico: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Alertaservicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="alertaservico-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
