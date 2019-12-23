<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Avisa_rotinaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="avisa-rotina-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'empresa_fk') ?>

    <?= $form->field($model, 'rotina_fk') ?>

    <?= $form->field($model, 'data_entrega') ?>

    <?= $form->field($model, 'status_chegada') ?>

    <?php // echo $form->field($model, 'status_entrega') ?>

    <?php // echo $form->field($model, 'data_chegada') ?>

    <?php // echo $form->field($model, 'data_pronto') ?>

    <?php // echo $form->field($model, 'data_entregue') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
