<?php

use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Fcaixa */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
    date_default_timezone_set('America/Sao_paulo');
    $data = date('Y-m-d H:i:s');
?>

<div class="venda-form col-sm-12">
    <div class="venda-form box box-primary">
        <?php $form = ActiveForm::begin(); ?>
        <div class="box-body table-responsive col-sm-8">
            <div class="col-lg-offset-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Abrir Caixa</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <?php
                                echo 'Data de abertura: '.$data;
                            ?>
                        </div>
                        <div class="col-sm-12">
                            <?= $form->field($model, 'data_fim')->widget(DateControl::classname(), [
                                'type'=>DateControl::FORMAT_DATE,
                                'widgetOptions' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'php:d/m/Y'
                                    ]
                                ],
                                'language' => 'pt-BR'
                            ]); ?>
                        </div>
                        <div class="col-sm-12">
                            <?= $form->field($model, 'valor_abertura')->textInput()?>
                        </div>
<!--                        <div class="col-sm-6">-->
<!--                            --><?php //echo $form->field($model, 'entrada')->textInput() ?>
<!--                        </div>-->
<!--                        <div class="col-sm-6">-->
<!--                            --><?php //echo $form->field($model, 'saida')->textInput() ?>
<!--                        </div>-->
<!--                        <div class="col-sm-6">-->
<!--                            --><?php //echo $form->field($model, 'saldo')->textInput() ?>
<!--                        </div>-->
                        <div>
                            <?= Html::a('Voltar', ['/site/index'],[ 'class' => 'btn btn-warning btn-flat']) ?>
                            <?= Html::submitButton('Fechar Caixa', ['class' => 'btn btn-success btn-flat pull-right', 'data' => [
                                'confirm' => "Deseja realmente fechar o caixa?",
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
</div>
