<?php

use app\models\Clienteavulso;
use app\models\Servico;
use app\widgets\Alert;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Alertaservico */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$servico = Servico::find()->all();
if($servico){
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
                                <?= $form->field($model, 'cliente_fk')->
                                dropDownList(ArrayHelper::map(Clienteavulso::find()->all(),'id', 'nome'),['prompt' => 'Selecione'])->
                                label('Cliente')
                                ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'data_entrega')->widget(DateControl::classname(), [
                                    'type'=>DateControl::FORMAT_DATE,
                                    'widgetOptions' => [
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'format' => 'php:d/m/Y'
                                        ]
                                    ],
                                    'language' => 'pt-BR'
                                ])->label('Data de Entrega'); ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($model, 'servico_fk')
                                    ->dropDownList(ArrayHelper::map(Servico::find()->all(),'id','descricao'),['prompt'=>'selecione'])
                                    ->label('Serviço')
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($model, 'quantidade')->textInput(['type' => 'number', 'default' => '1', 'value' => '1', 'min' => '1']) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($model, 'status_pagamento')->dropDownList([
                                    '0' => 'Aguardando Pagamento',
                                    '1' => 'Pago',
                                    '2' => 'Pago no honorário',
                                ],['prompt' => 'Selecione'])->label('Pagamento') ?>
                            </div>

                            <div class="col-sm-8 col-sm-offset-2">
                                <?= $form->field($model, 'info')->textarea(['rows' => 3])->label('Informações adicionais') ?>
                            </div>
                            <div class="col-sm-12">
                                <?= Html::a('Cancelar', ['/site/index'], ['class' => 'btn btn-warning btn-flat pull-left']) ?>
                                <?= Html::submitButton('Gerar Alerta', ['class' => 'btn btn-success btn-flat pull-right', 'data' => [
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

<?php }else{
    echo \yii\bootstrap\Alert::widget([
        'options' => [
            'class' => 'alert-warning',
        ],
        'body' => 'Para criar um alerta é necessário primeiramente cadastrar um serviço!',
    ]);
    echo Html::a('Cancelar', ['site/index'], ['class' => 'btn btn-danger btn-flat pull-left']);
    echo Html::a('Cadastrar Servico', ['servico/create'], ['class' => 'btn btn-success btn-flat pull-right']);
}
?>