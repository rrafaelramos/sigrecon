<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Venda */

$this->title = 'Finalizar Venda';
$this->params['breadcrumbs'][] = ['label' => 'Venda PF'];
$this->params['breadcrumbs'][] = ['label' => 'Venda Rápida'];
?>
<div class="venda-update">
    <?= $this->render('_formEditar', [
        'model' => $model,
    ]) ?>

</div>
