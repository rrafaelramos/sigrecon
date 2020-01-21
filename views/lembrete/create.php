<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Lembrete */

$this->title = 'Novo Lembrete';
$this->params['breadcrumbs'][] = ['label' => 'Lembrete', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lembrete-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
