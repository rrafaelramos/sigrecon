<?php

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
        <div class="col-sm-offset-2">
            <div class="clienteavulso-form col-sm-8">

                <div class="clienteavulso-form box box-primary">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="box-body table-responsive">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Dados do Serviço</h3>
                            </div>
                            <div class="panel-body">

                                <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'valor')->widget(MaskMoney::classname(), [
                                        'pluginOptions' => [
                                            'prefix' => 'R$ ',
                                            'suffix' => '',
                                            'allowNegative' => false
                                        ]
                                    ]);
                                    ?>
                                </div>
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'valor_minimo')->widget(MaskMoney::classname(), [
                                        'pluginOptions' => [
                                            'prefix' => 'R$ ',
                                            'suffix' => '',
                                            'allowNegative' => false
                                        ]
                                    ]);
                                    ?>
                                </div>

                                <div class="col-sm-12">
                                    <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-warning btn-flat']); ?>

                                    <?php if($model->id){
                                        echo Html::a('Apagar', ['delete', 'id' => $model->id], [
                                            'class' => 'btn btn-danger btn-flat',
                                            'data' => [
                                                'confirm' => 'Deseja realmente apagar?',
                                                'method' => 'post',
                                            ],
                                        ]);
                                    } ?>
                                    <?= Html::submitButton('Salvar', ['class' => 'btn btn-success btn-flat pull-right']) ?>
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
}else {
    echo '<center><div class="col-sm-4 col-sm-offset-4">';

    echo Alert::widget([
        'options' => [
            'class' => 'alert-warning',
        ],
        'body' => 'Somente o usuário Gerente pode cadastrar um serviço!',
    ]);

    echo Html::a(
        '<span class=""></span> Ir para Serviços',
        ['index'],
        ['data-method' => 'post', 'class' => 'btn btn-success btn-flat']
    );
}
echo '<center></div>';?>
