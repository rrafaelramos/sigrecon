<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Alertaservico */

$this->title = 'Editar Alerta: '.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Alerta de Serviços', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="alertaservico-update">

    <?= $this->render('_formEditar', [
        'model' => $model,
    ]) ?>

</div>
