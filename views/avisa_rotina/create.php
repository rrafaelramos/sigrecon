<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Avisa_rotina */

$this->title = 'Create Avisa Rotina';
$this->params['breadcrumbs'][] = ['label' => 'Avisa Rotinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="avisa-rotina-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
