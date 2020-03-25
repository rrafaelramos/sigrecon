<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Clienteavulso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clienteavulso-form">
    <div class="clienteavulso-form box box-primary">
        <?php $form = ActiveForm::begin(); ?>
        <div class="box-body table-responsive">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Dados da Contabilidade</h3>
                </div>
                <!--                div de Dados pessoais do Cliente-->
                <div class="panel-body">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'nome')->textInput(['maxlength' => true])->label('Nome da Empresa') ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'responsavel')->textInput(['maxlength' => true])->label('Gerente responsável') ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'cnpj')->widget(\yii\widgets\MaskedInput::className(),[
                            'mask' => '99.999.999/9999-99',
                            'clientOptions' => ['removeMaskOnSubmit' => true]
                        ])->label('CNPJ') ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($model, 'crc')->textInput(['maxlength' => true])->label('CRC')?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($model, 'telefone')->widget(\yii\widgets\MaskedInput::className(),[
                            'mask' => '(99) 9999-9999',
                            'clientOptions' => ['removeMaskOnSubmit' => true]
                        ]) ?>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Endereço</h3>
                </div>
                <div class="panel-body">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'rua')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-2">
                        <?= $form->field($model, 'numero')->textInput()->label('Número')?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'bairro')->textInput(['maxlength' => true]) ?>
                    </div>

                    <div class="col-sm-3">
                        <?= $form->field($model, 'cidade')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-12">
                        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success btn-flat pull-right']) ?>
                        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-warning btn-flat']) ?>
                        <?php
                        if($model->id){
                            echo Html::a('Apagar',['delete', 'id' => $model->id], ['class' => 'btn btn-danger btn-flat', 'data' => [
                                'confirm' => 'Deseja realmente apagar?',
                                'method' => 'post',
                            ],]);
                        }
                        ?>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
