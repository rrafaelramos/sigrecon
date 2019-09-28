<?php

use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Rotina */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rotina-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'repeticao')->dropDownList(['prompt' => 'Selecione um período para repetição:',
        '1' => 'Todo Mês',
        '2' => 'À cada Trimestre',
        '3' => 'À cada Semestre',
        '4' => 'Anualmente',
        ]) ?>

    <?= $form->field($model, 'doc_entrega')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'doc_busca')->textInput(['maxlength' => true]) ?>

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

    <?= $form->field($model, 'informacao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'msg_aviso')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
