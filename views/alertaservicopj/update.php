<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Alertaservicopj */

$this->title = 'Alerta PJ: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Alertaservicopjs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="alertaservicopj-update">

    <?= $this->render('_formEditar', [
        'model' => $model,
    ]) ?>

</div>
