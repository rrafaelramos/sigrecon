<?php

use app\models\Empresa;
use app\models\Rotina;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Avisa_rotina */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="avisa-rotina-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'empresa_fk')
            ->dropDownList(ArrayHelper::map(Empresa::find()->all(),'id','razao_social'),['prompt'=>'Selecione', 'disabled' => 'disabled'])
            ->label('Empresa')?>

        <?= $form->field($model, 'rotina_fk')->dropDownList(ArrayHelper::map(Rotina::find()->all(),'id','nome'),['disabled'=>'disabled'])
            ->label('Rotina')?>

        <?= $form->field($model, 'data_entrega')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATE,
            'widgetOptions' => [
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'php:d/m/Y H:i:s',
                ]
            ],'disabled' => 'disabled',
            'language' => 'pt-BR'
        ])->label('Data limite');
        ?>

        <?php if($model->status_chegada==0){
            echo $form->field($model, 'status_chegada')->dropDownList([
                'prompt'=> 'Selecione',
                '0' => 'Aguardando recebimento',
                '1' => 'Recebido'
            ])->label('Doc. à ser Recebido');
        }else{
            echo $form->field($model, 'status_chegada')->dropDownList([
                'prompt'=> 'Selecione',
                '0' => 'Aguardando recebimento',
                '1' => 'Recebido'
            ],['disabled' => 'disabled'])->label('Doc. à ser Recebido');
        }
        ?>

        <?php
        if($model->status_entrega == 2){
            echo $form->field($model, 'status_entrega')->dropDownList([
                'prompt'=> 'Selecione',
                '0' => 'Pendente',
                '1' => 'Pronto para entrega',
                '2' => 'Entregue'
            ],['disabled' => 'disabled']);
        }else{
            echo $form->field($model, 'status_entrega')->dropDownList([
                'prompt'=> 'Selecione',
                '0' => 'Pendente',
                '1' => 'Pronto para entrega',
                '2' => 'Entregue'
            ]);
        }
        ?>

        <?= $form->field($model, 'data_chegada')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATE,
            'widgetOptions' => [
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'php:d/m/Y',
                ]
            ],'disabled' => 'disabled',
            'language' => 'pt-BR'
        ])->label('Data recebimento doc. necessário');
        ?>

        <?= $form->field($model, 'data_pronto')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATE,
            'widgetOptions' => [
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'php:d/m/Y',
                ]
            ],'disabled' => 'disabled',
            'language' => 'pt-BR'
        ])->label('Data pronto');
        ?>

        <?= $form->field($model, 'data_entregue')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATE,
            'widgetOptions' => [
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'php:d/m/Y',
                ]
            ],'disabled' => 'disabled',
            'language' => 'pt-BR'
        ])->label('Data entregue');
        ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
