<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HonorarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="honorario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'valor') ?>

    <?= $form->field($model, 'data_pagamento') ?>

    <?= $form->field($model, 'referencia') ?>

    <?= $form->field($model, 'usuario_fk') ?>

    <?php // echo $form->field($model, 'empresa_fk') ?>

    <?php // echo $form->field($model, 'observacao') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
