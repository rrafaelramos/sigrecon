<?php

use app\models\Rotina;
use yii\bootstrap\Dropdown;
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
                        <?= $form->field($model, 'uf')->dropDownList(['prompt' => 'Selecione um Estado',
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
                            'TO' => 'TO']) ?>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Serviço Avulso ou Recorrente</h3>
                </div>
                <div class="panel-body">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'rotina')->dropDownList(ArrayHelper::map(Rotina::find()->all(),'id', 'nome'),['prompt' => 'Selecione a Rotina'])?>
                    </div>
                </div>
            </div>
            <div class="pull-right">
                <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-warning btn-flat']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?//= $form->field($model, 'usuario_fk')->dropDownList(ArrayHelper::map(DBUser::find()->where(['id' => Yii::$app->user->id])->all(), 'id','nome'));?>






</div>
