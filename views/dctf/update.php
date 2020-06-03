<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dctf */

$this->title = 'Atualizar DCTF';
$this->params['breadcrumbs'][] = ['label' => 'Dctfs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dctf-update">

    <?= $this->render('_formEditar', [
        'model' => $model,
    ]) ?>

</div>
