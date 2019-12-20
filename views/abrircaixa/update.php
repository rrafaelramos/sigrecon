<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Abrircaixa */

$this->title = 'Abrir Caixa';
$this->params['breadcrumbs'][] = ['label' => 'Abrircaixas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="abrircaixa-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
