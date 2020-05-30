<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rais */

$this->title = 'Atualizar RAIS';
$this->params['breadcrumbs'][] = ['label' => 'Rais', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rais-update">

    <?= $this->render('_formEditar', [
        'model' => $model,
    ]) ?>

</div>
