<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MensagemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mensagem-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'emissor') ?>

    <?= $form->field($model, 'receptor') ?>

    <?= $form->field($model, 'data_envio') ?>

    <?= $form->field($model, 'titulo') ?>

    <?php // echo $form->field($model, 'conteudo') ?>

    <?php // echo $form->field($model, 'empresa_fk') ?>

    <?php // echo $form->field($model, 'servico_fk') ?>

    <?php // echo $form->field($model, 'lido') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
