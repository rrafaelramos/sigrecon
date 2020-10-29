<?php

use app\models\Rotina;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;


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
                    <h3 class="panel-title">Dados Pessoais</h3>
                </div>
                <!--                div de Dados pessoais do Cliente-->
                <div class="panel-body">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'cpf')->widget(\yii\widgets\MaskedInput::className(),[
                            'mask' => '999.999.999-99',
                            'clientOptions' => ['removeMaskOnSubmit' => true]
                        ]) ?>

                    </div>
                    <div class="col-sm-6">
                        <?=
                        $form->field($model, 'datanascimento')->widget(DateControl::classname(), [
                            'type'=>DateControl::FORMAT_DATE,
                            'widgetOptions' => [
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'php:d/m/Y'
                                ]
                            ],
                            'language' => 'pt-BR'
                        ]); ?>

                        <?= $form->field($model, 'telefone')->widget(\yii\widgets\MaskedInput::className(),[
                            'mask' => '(99) 9 9999-9999',
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
                    <div class="col-sm-4">
                        <?= $form->field($model, 'bairro')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-2">
                        <?= $form->field($model, 'numero')->textInput() ?>
                    </div>
                    <div class="col-sm-5">
                        <?= $form->field($model, 'cidade')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-2">
                        <?= $form->field($model, 'cep')->widget(\yii\widgets\MaskedInput::className(),[
                            'mask' => '99.999-999',
                            'clientOptions' => ['removeMaskOnSubmit' => true]
                        ]) ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($model, 'complemento')->textInput() ?>
                    </div>
                    <div class="col-sm-2">
                       <?php $list = ['AC' => 'AC',
                           'AL' => 'AL',
                           'AM' => 'AM',
                           'AP' => 'AP',
                           'BA' => 'BA',
                           'CE' => 'CE',
                           'DF' => 'DF',
                           'ES' => 'ES',
                           'GO' => 'GO',
                           'MA' => 'MA',
                           'MG' => 'MG',
                           'MS' => 'MS',
                           'MT' => 'MT',
                           'PA' => 'PA',
                           'PB' => 'PB',
                           'PE' => 'PE',
                           'PI' => 'PI',
                           'PR' => 'PR',
                           'RJ' => 'RJ',
                           'RN' => 'RN',
                           'RO' => 'RO',
                           'RR' => 'RR',
                           'RS' => 'RS',
                           'SC' => 'SC',
                           'SE' => 'SE',
                           'SP' => 'SP',
                           'TO' => 'TO']; ?>
                        <?= $form->field($model, 'uf')->dropDownList($list,['prompt' => 'Selecione']); ?>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Serviço Recorrente</h3>
                </div>
                <div class="panel-body">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'rotina')->dropDownList([
                                // '1' é o id do Simples Nacional
                                '2' => 'IRPF - Imposto de Renda Pessoa Física',
                                '3' => 'ITR - Imposto sobre Propriedade Territorial Rural'
                            ], ['prompt' => 'Selecione'])?>
                    </div>
                </div>
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
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
