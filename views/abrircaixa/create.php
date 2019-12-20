<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Abrircaixa */

$this->title = 'Abrir o Caixa';
$this->params['breadcrumbs'][] = ['label' => 'Abrircaixas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="abrircaixa-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
