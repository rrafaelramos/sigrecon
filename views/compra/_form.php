<?php

use app\models\DBUser;
use app\models\User;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Compra */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="compra-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'usuario_fk')->dropDownList(ArrayHelper::map(DBUser::find()->where(['nome' => yii::$app->session])
        ->all(), 'id','nome'));?>

    <?= $form->field($model, 'quantidade')->textInput() ?>

    <?=
    $form->field($model, 'data')->widget(DateControl::classname(), [
        'type'=>DateControl::FORMAT_DATE,
        'widgetOptions' => [
            'pluginOptions' => [
                'autoclose' => true
             ]
        ],
        'language' => 'pt-BR'
    ]); ?>

    <?= $form->field($model, 'valor')->textInput() ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
