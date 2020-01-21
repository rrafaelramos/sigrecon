<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Lembrete */

$this->title = 'Editar Lembrete: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lembrete', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="lembrete-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
