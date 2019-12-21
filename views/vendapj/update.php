<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Vendapj */

$this->title = 'Finalizar Venda';
$this->params['breadcrumbs'][] = ['label' => 'Venda PJ', 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Finalizar Venda', 'url' => ['view', 'id' => $model->id]];
?>
<div class="vendapj-update">

    <?= $this->render('_formEditar', [
        'model' => $model,
    ]) ?>

</div>
