<?php

use app\models\Clienteavulso;
use app\models\Empresa;
use app\models\Servico;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Alertaservico */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="venda-form col-sm-12">
    <div class="venda-form box box-primary">
        <?php $form = ActiveForm::begin(); ?>
        <div class="box-body table-responsive col-sm-11">
            <div class="col-lg-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Alerta: Servico Pendente</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-6">
                            <?= $form->field($model, 'empresa_fk')->
                            dropDownList(ArrayHelper::map(Empresa::find()->all(),'id', 'razao_social'),['prompt' => 'Selecione', 'disabled' => 'disabled'])->
                            label('Cliente');
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'data_entrega')->widget(DateControl::classname(), [
                                'type'=>DateControl::FORMAT_DATE,
                                'widgetOptions' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'php:d/m/Y H:i:s',
                                    ]
                                ],'disabled' => 'disabled',
                                'language' => 'pt-BR'
                            ])->label('Data para Entrega'); ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'servico_fk')
                                ->dropDownList(ArrayHelper::map(Servico::find()->all(),'id','descricao'),['prompt'=>'selecione', 'disabled' => 'disabled'])
                                ->label('Serviço')
                            ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'quantidade')->textInput(['type'=>'number','disabled' => 'disabled']) ?>
                        </div>

                        <?php
                        if($model->status_pagamento == 1 || $model->status_pagamento == 2){
                            ?>
                            <div class="col-sm-2">
                                <?= $form->field($model, 'status_pagamento')->dropDownList([
                                    '0' => 'Aguardando Pagamento',
                                    '1' => 'Pago',
                                    '2' => 'Pago no honorário',
                                ],['prompt' => 'Selecione', 'disabled' => 'disabled'])->label('Pagamento') ?>
                            </div>
                        <?php }else{ ?>
                            <div class="col-sm-2">
                                <?= $form->field($model, 'status_pagamento')->dropDownList([
                                    '0' => 'Aguardando Pagamento',
                                    '1' => 'Pago',
                                    '2' => 'Pago no honorário',
                                ],['prompt' => 'Selecione'])->label('Pagamento') ?>
                            </div>
                        <?php } ?>

                        <div class="col-sm-2">
                            <?= $form->field($model, 'status_servico')->dropDownList([
                                '0' => 'Pendente',
                                '1' => 'Pronto para entrega',
                                '2' => 'Entregue',
                            ],['prompt' => 'Selecione'])->label('Status') ?>
                        </div>

                        <div class="col-sm-8 col-sm-offset-2">
                            <?= $form->field($model, 'info')->textarea(['rows' => 3,'disabled' => 'disabled'])->label('Informações adicionais') ?>
                        </div>
                        <div class="col-sm-12">
                            <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-warning btn-flat pull-left']) ?>
                            <?= Html::submitButton('Atualizar', ['class' => 'btn btn-success btn-flat pull-right', 'data' => [
                                'confirm' => "Deseja realmente Salvar?",
                                'method' => 'post',
                            ]]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

