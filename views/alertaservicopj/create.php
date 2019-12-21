<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Alertaservicopj */

$this->title = 'Cadastrar Alerta PJ';
$this->params['breadcrumbs'][] = ['label' => 'Alertaservicopjs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alertaservicopj-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
