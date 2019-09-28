<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmpresaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empresa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cnpj') ?>

    <?= $form->field($model, 'razao_social') ?>

    <?= $form->field($model, 'nome_fantasia') ?>

    <?= $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'telefone') ?>

    <?php // echo $form->field($model, 'celular') ?>

    <?php // echo $form->field($model, 'numero') ?>

    <?php // echo $form->field($model, 'complemento') ?>

    <?php // echo $form->field($model, 'rua') ?>

    <?php // echo $form->field($model, 'bairro') ?>

    <?php // echo $form->field($model, 'cidade') ?>

    <?php // echo $form->field($model, 'cep') ?>

    <?php // echo $form->field($model, 'uf') ?>

    <?php // echo $form->field($model, 'data_abertura') ?>

    <?php // echo $form->field($model, 'data_procuracao') ?>

    <?php // echo $form->field($model, 'data_certificado') ?>

    <?php // echo $form->field($model, 'rotina') ?>

    <?php // echo $form->field($model, 'responsavel') ?>

    <?php // echo $form->field($model, 'cpf_socio') ?>

    <?php // echo $form->field($model, 'datanascimento_socio') ?>

    <?php // echo $form->field($model, 'rg') ?>

    <?php // echo $form->field($model, 'titulo') ?>

    <?php // echo $form->field($model, 'nome_mae_socio') ?>

    <?php // echo $form->field($model, 'telefone_socio') ?>

    <?php // echo $form->field($model, 'usuario_fk') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
