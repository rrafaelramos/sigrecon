<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Clienteavulso */

$this->title = 'Editar: ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="clienteavulso-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
