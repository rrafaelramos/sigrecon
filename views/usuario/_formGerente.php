<?php

use yii\bootstrap\Alert;
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
                        <h3 class="panel-title">Conceder Autorização</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'nome')->textInput(['maxlength' => true ,'disabled' => 'disabled'])->label('Nome Completo') ?>

                            <?= $form->field($model, 'email', $email)->textInput(['maxlength' => true,'disabled' => 'disabled'])->label('e-Mail') ?>

                            <?= $form->field($model, 'username', $usuario)->textInput(['maxlength' => true,'disabled' => 'disabled'])->label('Usuário') ?>

                            <?php //echo $form->field($model, 'password', $cadeado)->passwordInput(['maxlength' => true,'disabled' => 'disabled'])->label('Senha') ?>

                            <?php if(Yii::$app->user->identity->email != $model->email && $model->tipo != 1) {
                                echo $form->field($model, 'tipo')->dropDownList([
                                    'prompt' => 'Selecione',
                                    '1' => 'Gerente',
                                    '2' => 'Colaborador',
                                    '3' => 'Recusar Solicitação'
                                ])->label('Conceder Autorização');
                                echo Html::submitButton('Autorizar', ['class' => 'btn btn-success btn-flat pull-right']);
                            }else{
                                echo Alert::widget([
                                    'options' => [
                                        'class' => 'alert-warning',
                                    ],
                                    'body' => 'Usuário não autorizado a executar esta ação!',
                                ]);
                                echo Html::a('Voltar',['/site/index'], ['class' => 'btn btn-warning btn-flat pull-right']);
                            }
                            ?>

                            <?php // echo $form->field($model, 'authKey')->textInput(['maxlength' => true]) ?>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php ActiveForm::end(); ?>
