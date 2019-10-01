<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Rotina */

$this->title = 'Cadastrar Rotina';
$this->params['breadcrumbs'][] = ['label' => 'Rotinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rotina-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
