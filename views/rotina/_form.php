<?php

use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Rotina */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clienteavulso-form">

    <div class="clienteavulso-form box box-primary">
        <?php $form = ActiveForm::begin(); ?>
        <div class="box-body table-responsive">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Cadastro de Rotina</h3>
                </div>
                <div class="panel-body">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'repeticao')->dropDownList(['prompt' => 'Selecione um período para repetição:',
                            '1' => 'Todo Mês',
                            '2' => 'À cada Trimestre',
                            '3' => 'À cada Semestre',
                            '4' => 'Anualmente',
                        ]) ?>
                    </div>
                    <div class="col-sm-12">
                        <hr>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'doc_entrega')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-6">
                            <?= $form->field($model, 'doc_busca')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="box-body table-responsive">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Datas</h3>
                </div>

                <div class="panel-body">
                    <div class="col-sm-6">
                        <?=
                        $form->field($model, 'data_entrega')->widget(DateControl::classname(), [
                            'type'=>DateControl::FORMAT_DATE,
                            'widgetOptions' => [
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ],
                            'language' => 'pt-BR'
                        ]); ?>
                    </div>
                    <div class="col-sm-6">
                        <?=
                        $form->field($model, 'data_aviso')->widget(DateControl::classname(), [
                            'type'=>DateControl::FORMAT_DATE,
                            'widgetOptions' => [
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ],
                            'language' => 'pt-BR'
                        ]); ?>
                    </div>
                    <div class="col-sm-12">
                        <hr>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'informacao')->textarea(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'msg_aviso')->textarea(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>

            <div class="pull-right">
                <?= Html::submitButton('Salvar', ['class' => 'btn btn-success btn-flat']) ?>
                <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-warning btn-flat']) ?>
                <?= Html::a('Apagar',['delete', 'id' => $model->id], ['class' => 'btn btn-danger btn-flat', 'data' => [
                    'confirm' => 'Deseja realmente apagar?',
                    'method' => 'post',
                ],]) ?>
            </div>

        </div>
    </div>
</div>

    <?php ActiveForm::end(); ?>

</div>
