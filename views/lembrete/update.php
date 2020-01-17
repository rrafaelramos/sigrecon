<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Lembrete */

$this->title = 'Update Lembrete: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lembretes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lembrete-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
