<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Honorario */

$this->title = 'Editar Honorário';
$this->params['breadcrumbs'][] = ['label' => 'Caixa'];
$this->params['breadcrumbs'][] = ['label' => 'Lançar Honorário'];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="honorario-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
