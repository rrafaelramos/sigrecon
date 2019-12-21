<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Vendapj */

$this->title = 'Realizar Venda';
$this->params['breadcrumbs'][] = ['label' => 'Venda PJ', 'url' => ['create']];
?>
<div class="vendapj-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
