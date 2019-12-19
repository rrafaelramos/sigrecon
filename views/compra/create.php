<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Compra */

$this->title = 'Registrar compra';
$this->params['breadcrumbs'][] = ['label' => 'Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="compra-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
