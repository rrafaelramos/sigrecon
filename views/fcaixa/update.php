<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fcaixa */

$this->title = 'Fechar o Caixa';
$this->params['breadcrumbs'][] = ['label' => 'Fcaixas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fcaixa-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
