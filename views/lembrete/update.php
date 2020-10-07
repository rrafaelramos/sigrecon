<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Lembrete */

$this->title = 'Editar Compromisso: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Compromisso', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="lembrete-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
