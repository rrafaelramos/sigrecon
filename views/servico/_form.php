<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Servico */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="col-sm-12">
    <div class="col-sm-offset-4">
        <div class="clienteavulso-form col-sm-6">

            <div class="clienteavulso-form box box-primary">
                <?php $form = ActiveForm::begin(); ?>
                <div class="box-body table-responsive">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Dados do Serviço</h3>
                        </div>
                        <div class="panel-body">
                            <div>
                                <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>
                                <?= $form->field($model, 'valor')->textInput() ?>
                                <?= $form->field($model, 'valor_minimo')->textInput() ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-warning btn-flat']); ?>
                                <?= Html::submitButton('Salvar', ['class' => 'btn btn-success btn-flat']) ?>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

