<?php
use kartik\money\MaskMoney;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Esqueci a Senha:';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>SIGRE</b>con</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Informe seu email</p>

<!--        --><?php $form = ActiveForm::begin(['id' => 'recuperar', 'action' => 'index.php?r=usuario/recuperar']); ?>

        <?= $form
            ->field($model, 'email')
            ->label('Email')
            ->textInput(['placeholder' => $model->getAttributeLabel('Email')]) ?>

        <div class="row">
            <div class="col-xs-8">

            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Verificar', ['class' => 'btn btn-primary btn-block btn-flat']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

    </div>
    <center>
        <br>
        <a href="index.php?r=" class="text-center">Cancelar</a>
    </center>
</div><!-- /.login-box -->