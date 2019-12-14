<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Alertaservico */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alertaservico-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'cliente_fk')->textInput() ?>

        <?= $form->field($model, 'data_entrega')->textInput() ?>

        <?= $form->field($model, 'servico_fk')->textInput() ?>

        <?= $form->field($model, 'quantidade')->textInput() ?>

        <?= $form->field($model, 'info')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'status_pagamento')->textInput() ?>

        <?= $form->field($model, 'status_servico')->textInput() ?>

        <?= $form->field($model, 'usuario_fk')->textInput() ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
