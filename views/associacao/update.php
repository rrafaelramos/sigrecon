<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Associacao */

$this->title = 'Editar: ' . $model->razao_social;
$this->params['breadcrumbs'][] = ['label' => 'Associacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="associacao-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
