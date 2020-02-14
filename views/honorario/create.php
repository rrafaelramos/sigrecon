<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Honorario */

$this->title = 'Lançar Honorário';
$this->params['breadcrumbs'][] = ['label' => 'Caixa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="honorario-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
