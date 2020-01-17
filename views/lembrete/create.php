<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Lembrete */

$this->title = 'Create Lembrete';
$this->params['breadcrumbs'][] = ['label' => 'Lembretes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lembrete-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
