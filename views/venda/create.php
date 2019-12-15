<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Venda */

$this->title = 'Realizar Venda';
$this->params['breadcrumbs'][] = ['label' => 'Vendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="venda-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
