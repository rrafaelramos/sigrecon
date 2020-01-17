<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Mensagem */

$this->title = 'Editar';
$this->params['breadcrumbs'][] = ['label' => 'Recados', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="Recado-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
