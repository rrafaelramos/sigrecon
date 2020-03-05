<?php

use app\models\Usuario;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Mensagem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-sm-12">
    <div class="mensagem-form col-sm-12">
        <div class="mensagem-form box box-primary">
            <?php $form = ActiveForm::begin(); ?>
            <div class="box-body table-responsive col-sm-6 col-sm-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Enviar recado</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <?php
                            //echo $form->field($model, 'emissor')->textInput();
                            $model->emissor = Yii::$app->user->identity->id;
                            ?>

                            <?php
                                $aux = array();
                                $cont = 0;
                                $usuarios = Usuario::find()->all();
                                foreach ($usuarios as $u){
                                    if($u->id != Yii::$app->user->identity->id){
                                        $aux[$cont] = $u;
                                    }
                                    $cont++;
                                }
                                unset($cont);
                                unset($usuarios);
                            ?>

                            <?= $form->field($model, 'receptor')->dropDownList(ArrayHelper::map($aux,'id','nome'),['prompt' => 'Selecione'])->label('Destinatário') ?>

                            <?php //echo $form->field($model, 'data_envio')->textInput(); ?>

                            <?= $form->field($model, 'titulo')->textInput(['maxlength' => true])->label('Título do Recado') ?>

                            <?= $form->field($model, 'conteudo')->textarea(['rows' => 6])->label('Conteúdo') ?>

                            <?php //echo $form->field($model, 'lido')->textInput(); ?>
                            <?= Html::a('Cancelar', ['/site/index'],['class' => 'btn btn-warning btn-flat']) ?>
                            <?= Html::submitButton('Enviar', ['class' => 'btn btn-success btn-flat pull-right']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php ActiveForm::end(); ?>

