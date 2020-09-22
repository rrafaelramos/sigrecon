<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';

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
        <p class="login-box-msg">Faça login para iniciar sua sessão</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label('Usuário')
            ->textInput(['placeholder' => $model->getAttributeLabel('Usuário')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label("Senha")
            ->passwordInput(['placeholder' => $model->getAttributeLabel('Senha')]) ?>

        <div class="row">
            <div class="col-xs-8">

            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'recuperar-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

        <a href="index.php?r=usuario/create" class="text-center">Registrar um novo membro</a><br>
        <a href="index.php?r=usuario/esqueci" class="text-center">Esqueci a minha senha</a>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->