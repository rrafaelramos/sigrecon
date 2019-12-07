<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Servico */

$this->title = 'Editar Serviço: ' . $model->descricao;
$this->params['breadcrumbs'][] = ['label' => 'Serviços', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descricao, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="servico-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
