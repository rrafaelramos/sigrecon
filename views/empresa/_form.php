<?php

use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Rotina;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $model app\models\Empresa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empresa-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>


    <?php echo date("d/m/Y"); ?>



    <div class="box-body table-responsive">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Dados da Empresa</h3>
            </div>
            <div class="panel-body">

                <div class="col-sm-6">
                    <?= $form->field($model, 'cnpj')->widget(\yii\widgets\MaskedInput::className(),[
                        'mask' => '99.999.999/9999-99',
                        'clientOptions' => ['removeMaskOnSubmit' => true]
                    ]) ?>
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'celular')->widget(\yii\widgets\MaskedInput::className(),[
                        'mask' => '(99) 9 9999-9999',
                        'clientOptions' => ['removeMaskOnSubmit' => true]
                    ]) ?>
                </div>

                <div class="col-sm-6">
                    <?= $form->field($model, 'razao_social')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'nome_fantasia')->textInput(['maxlength' => true]) ?>
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
                    <?= $form->field($model, 'complemento')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($model, 'uf')->dropDownList([
                        'AC' => 'AC',
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
                        'TO' => 'TO'], ['prompt' => 'Selecione um Estado']) ?>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Informações adicionais</h3>
            </div>
            <div class="panel-body">
                <div class="col-sm-3">
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
                </div>
                <div class="col-sm-3">
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
                </div>
                <div class="col-sm-3">
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
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'rotina')->dropDownList(ArrayHelper::map(Rotina::find()->all(),'id', 'nome'),['prompt' => 'Selecione uma Rotina', 'id' => 'id'])?>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Dados do Sócio-Administrador</h3>
            </div>
            <div class="panel-body">
                <div class="col-sm-4">
                    <?= $form->field($model, 'responsavel')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'nome_mae_socio')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'cpf_socio')->widget(\yii\widgets\MaskedInput::className(),[
                        'mask' => '999.999.999-99',
                        'clientOptions' => ['removeMaskOnSubmit' => true]
                    ]) ?>
                    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'rg')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'datanascimento_socio')->widget(DateControl::classname(), [
                        'type'=>DateControl::FORMAT_DATE,
                        'widgetOptions' => [
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'php:d/m/Y',
                                'language' => 'pt-BR'
                            ]
                        ],
                        'language' => 'pt-BR'
                    ]); ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($model, 'telefone_socio')->widget(\yii\widgets\MaskedInput::className(),[
                        'mask' => '(99) 99999-9999',
                        'clientOptions' => ['removeMaskOnSubmit' => true]
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="pull-right">
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-warning btn-flat']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
