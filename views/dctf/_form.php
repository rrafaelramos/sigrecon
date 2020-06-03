<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dctf */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dctf-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'associacao_id')->textInput() ?>

        <?= $form->field($model, 'associacao_nome')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'data_limite')->textInput() ?>

        <?= $form->field($model, 'presidente')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'fone_presidente')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'feito')->textInput(['maxlength' => true]) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
