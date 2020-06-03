<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ecf */

$this->title = 'Atualizar ECF';
$this->params['breadcrumbs'][] = ['label' => 'Ecfs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ecf-update">

    <?= $this->render('_formEditar', [
        'model' => $model,
    ]) ?>

</div>
