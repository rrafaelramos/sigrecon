<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rotina */

$this->title = 'Update Rotina: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Rotinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rotina-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
