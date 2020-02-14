<?php

use kartik\money\MaskMoney;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Compra */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="venda-form col-sm-12">
    <div class="venda-form box box-primary">
        <?php $form = ActiveForm::begin(); ?>
        <div class="box-body table-responsive col-sm-8">
            <div class="col-lg-offset-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lançar Saída</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'descricao')->textInput(['maxlength' => true])->label('Descrição') ?>
                        </div>
<!--                        <div class="col-sm-6">-->
<!--                            --><?php //echo $form->field($model, 'quantidade')->textInput(['type' => 'number', 'default' => '1', 'value' => '1', 'min' => '1']) ?>
<!--                        </div>-->
                        <div class="col-sm-12">
                            <?= $form->field($model, 'valor')->widget(MaskMoney::classname(), [
                                'pluginOptions' => [
                                    'prefix' => 'R$ ',
                                    'suffix' => '',
                                    'allowNegative' => false
                                ]
                            ])->label('Valor');
                            ?>
                        </div>
                        <div class="col-sm-12">
                            <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-warning btn-flat pull-left']) ?>
                            <?= Html::submitButton('Retirar', ['class' => 'btn btn-success btn-flat pull-right', 'data' => [
                                'confirm' => "Deseja realmente Salvar?",
                                'method' => 'post',
                            ]]) ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
