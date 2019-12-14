<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaservicoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alertaservico-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cliente_fk') ?>

    <?= $form->field($model, 'data_entrega') ?>

    <?= $form->field($model, 'servico_fk') ?>

    <?= $form->field($model, 'quantidade') ?>

    <?php // echo $form->field($model, 'info') ?>

    <?php // echo $form->field($model, 'status_pagamento') ?>

    <?php // echo $form->field($model, 'status_servico') ?>

    <?php // echo $form->field($model, 'usuario_fk') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
