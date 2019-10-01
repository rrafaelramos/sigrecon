<?php

use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Empresa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empresa-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'cnpj')->widget(\yii\widgets\MaskedInput::className(),[
            'mask' => '99.999.999/9999-99',
            'clientOptions' => ['removeMaskOnSubmit' => true]
        ]) ?>

        <?= $form->field($model, 'razao_social')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'nome_fantasia')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'telefone')->widget(\yii\widgets\MaskedInput::className(),[
            'mask' => '(99) 9999-9999',
            'clientOptions' => ['removeMaskOnSubmit' => true]
        ]) ?>

        <?= $form->field($model, 'celular')->widget(\yii\widgets\MaskedInput::className(),[
            'mask' => '(99) 9 9999-9999',
            'clientOptions' => ['removeMaskOnSubmit' => true]
        ]) ?>

        <?= $form->field($model, 'numero')->textInput() ?>

        <?= $form->field($model, 'complemento')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'rua')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'bairro')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'cidade')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'cep')->widget(\yii\widgets\MaskedInput::className(),[
            'mask' => '99.999-999',
            'clientOptions' => ['removeMaskOnSubmit' => true]
        ]) ?>

        <?= $form->field($model, 'uf')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'data_abertura')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATE,
            'widgetOptions' => [
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'php:d/m/Y'
                ]
            ],
            'language' => 'pt-BR'
        ]); ?>

        <?= $form->field($model, 'data_procuracao')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATE,
            'widgetOptions' => [
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'php:d/m/Y'
                ]
            ],
            'language' => 'pt-BR'
        ]); ?>

        <?= $form->field($model, 'data_certificado')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATE,
            'widgetOptions' => [
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'php:d/m/Y'
                ]
            ],
            'language' => 'pt-BR'
        ]); ?>

        <?= $form->field($model, 'rotina')->textInput() ?>

        <?= $form->field($model, 'responsavel')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'cpf_socio')->widget(\yii\widgets\MaskedInput::className(),[
            'mask' => '999.999.999-99',
            'clientOptions' => ['removeMaskOnSubmit' => true]
        ]) ?>

        <?= $form->field($model, 'datanascimento_socio')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATE,
            'widgetOptions' => [
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'php:d/m/Y'
                ]
            ],
            'language' => 'pt-BR'
        ]); ?>

        <?= $form->field($model, 'rg')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'nome_mae_socio')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'telefone_socio')->widget(\yii\widgets\MaskedInput::className(),[
            'mask' => '(99) 9999-9999',
            'clientOptions' => ['removeMaskOnSubmit' => true]
        ]) ?>

        <?= $form->field($model, 'usuario_fk')->textInput() ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
