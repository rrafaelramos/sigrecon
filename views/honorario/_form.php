<?php

use app\models\Empresa;
use kartik\datecontrol\DateControl;
use kartik\money\MaskMoney;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Honorario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="honorario-form col-sm-12">
    <div class="honorario-form box box-primary">
        <?php $form = ActiveForm::begin(); ?>
        <div class="box-body table-responsive col-sm-8">
            <div class="col-lg-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lançamento de Honorário</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-8">
                            <?= $form->field($model, 'empresa_fk')->dropDownList(ArrayHelper::map(Empresa::find()->all(),'id','razao_social'),['prompt' => 'Selecione'])->label('Empresa') ?>
                        </div>

                        <div class="col-sm-4">
                            <?= $form->field($model, 'valor')->widget(MaskMoney::classname(), [
                                'pluginOptions' => [
                                    'prefix' => 'R$ ',
                                    'suffix' => '',
                                    'allowNegative' => false,
                                    'id' => 'total',
                                    'name' => 'total',
                                ]
                            ])->label('Valor Pago');
                            ?>
                        </div>

                        <div class="col-sm-12">
                            <?= $form->field($model, 'observacao')->textarea(['rows' => 3])->label('Observação') ?>
                        </div>
                        <div class="col-sm-6 col-sm-offset-3 ">
                            <?= $form->field($model, 'referencia')->widget(DateControl::classname(), [
                                'type'=>DateControl::FORMAT_DATE,
                                'widgetOptions' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'php:d/m/Y'
                                    ]
                                ],
                                'language' => 'pt-BR'
                            ]); ?>
                        </div>

                        <!--        --><?php //echo $form->field($model, 'data_pagamento')->textInput() ?>

                        <!--        --><?php //echo $form->field($model, 'referencia')->textInput() ?>

                        <!--        --><?php //echo $form->field($model, 'usuario_fk')->textInput() ?>
                        <div class="col-sm-12">
                            <?= Html::a('Cancelar',['/site/index'], ['class' => 'btn btn-warning btn-flat pull-left']) ?>
                            <?= Html::submitButton('Salvar', ['class' => 'btn btn-success btn-flat pull-right',
                                'data' => [
                                    'confirm' => 'Deseja realmente salvar?',
                                    'method' => 'post',
                                ],]) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
