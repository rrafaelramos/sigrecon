<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Clienteavulso */

$this->title = 'Update Clienteavulso: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Clienteavulsos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="clienteavulso-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
