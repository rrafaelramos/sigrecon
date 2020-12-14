<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Compra */

$this->title = 'Registrar Despesa';
$this->params['breadcrumbs'][] = ['label' => 'Caixa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="compra-saida">

    <?= $this->render('_formSaida', [
    'model' => $model,
    ]) ?>

</div>
