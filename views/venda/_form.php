<?php

use app\models\Clienteavulso;
use app\models\Empresa;
use app\models\Servico;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Venda */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="col-sm-12">
    <div class="col-sm-offset-2">
        <div class="venda-form col-sm-10">

            <div class="venda-form box box-primary">
                <?php $form = ActiveForm::begin(); ?>
                <div class="box-body table-responsive col-sm-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Venda de Serviço Avulso</h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-6">
                                <?= $form->field($model, 'cliente_fk')->dropDownList(ArrayHelper::map(Clienteavulso::find()->all(), 'id', 'nome'), ['prompt' => 'Selecione'])->label('Nome do Cliente',[''])?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'data')->widget(DateControl::classname(), [
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
                            <div class="col-sm-6">
                                <?= $form->field($model, 'servico_fk')->dropDownList(ArrayHelper::map(Servico::find()->all(),'id', 'descricao'),['prompt' => 'Selecione']) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'quantidade')->textInput() ?>
                            </div>
                            <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat pull-right']) ?>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


