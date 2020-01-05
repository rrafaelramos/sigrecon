<?php

//use app\widgets\Alert;
use kartik\money\MaskMoney;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\Servico */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
//1 é gerente
if(Yii::$app->user->identity->tipo == 1) {
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

                                    <?= $form->field($model, 'valor')->widget(MaskMoney::classname(), [
                                        'pluginOptions' => [
                                            'prefix' => 'R$ ',
                                            'suffix' => '',
                                            'allowNegative' => false
                                        ]
                                    ]);
                                    ?>

                                    <?= $form->field($model, 'valor_minimo')->widget(MaskMoney::classname(), [
                                        'pluginOptions' => [
                                            'prefix' => 'R$ ',
                                            'suffix' => '',
                                            'allowNegative' => false
                                        ]
                                    ]);
                                    ?>

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

    <?php
}else{
    echo Alert::widget([
        'options' => [
            'class' => 'alert-warning',
        ],
        'body' => 'Somente o usuário Gerente pode cadastrar um serviço!',
    ]);
}
?>