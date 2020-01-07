<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>
<?php

$usuario = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$cadeado = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];

$email = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

?>

<div class="col-sm-12">
    <div class="usuario-form col-sm-12">
        <div class="usuario-form box box-primary">
            <?php $form = ActiveForm::begin(); ?>
            <div class="box-body table-responsive col-sm-6 col-sm-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Solicitar Acesso</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'nome')->textInput(['maxlength' => true])->label('Nome Completo') ?>

                            <?= $form->field($model, 'email', $email)->textInput(['maxlength' => true])->label('e-Mail') ?>

                            <?= $form->field($model, 'username', $usuario)->textInput(['maxlength' => true])->label('Usuário') ?>

                            <?= $form->field($model, 'password', $cadeado)->passwordInput(['maxlength' => true])->label('Senha') ?>

                            <?php //echo $form->field($model, 'tipo')->textInput() ?>

                            <?php // echo $form->field($model, 'authKey')->textInput(['maxlength' => true]) ?>
                            <?php if(Yii::$app->user->isGuest) {
                                echo Html::submitButton('Solicitar', ['class' => 'btn btn-success btn-flat pull-right']);
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php ActiveForm::end(); ?>
