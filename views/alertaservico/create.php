<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Alertaservico */

$this->title = 'Cadastrar Alerta PF';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alertaservico-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
