<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Avisa_rotina */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="avisa-rotina-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'empresa_fk')->textInput() ?>

        <?= $form->field($model, 'rotina_fk')->textInput() ?>

        <?= $form->field($model, 'data_entrega')->textInput() ?>

        <?= $form->field($model, 'status_chegada')->textInput() ?>

        <?= $form->field($model, 'status_entrega')->textInput() ?>

        <?= $form->field($model, 'data_chegada')->textInput() ?>

        <?= $form->field($model, 'data_pronto')->textInput() ?>

        <?= $form->field($model, 'data_entregue')->textInput() ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
