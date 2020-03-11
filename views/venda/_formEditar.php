<?php

use app\models\Clienteavulso;
use app\models\Servico;
use kartik\money\MaskMoney;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Venda */
/* @var $form yii\widgets\ActiveForm */

?>

<?php
function formatar($model){
    $formatter = Yii::$app->formatter;
    $formatado = $formatter->asCurrency($model);
    $dinheiro = str_replace("pt-br", "R$", $formatado);
    return $dinheiro;
}
?>

<?php
if(!Yii::$app->user->isGuest){
    ?>
    <div class="col-sm-12">
        <div class="venda-form col-sm-12">
            <div class="venda-form box box-primary">
                <?php $form = ActiveForm::begin(); ?>
                <div class="box-body table-responsive col-sm-6 col-sm-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Venda Rápida</h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12">
                                <?= $form->field($model, 'cliente_fk')->
                                dropDownList(ArrayHelper::map(Clienteavulso::find()->all(),'id', 'nome'),['prompt' => 'Selecione', 'disabled' => 'disabled'])->
                                label('Cliente');
                                ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'servico_fk')
                                    ->dropDownList(ArrayHelper::map(Servico::find()->all(),'id', 'descricao'),['prompt' => 'Selecione', 'disabled' => 'disabled'])?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'quantidade')->textInput([ 'type' => 'number', 'id' => 'quantidade', 'disabled' => 'disabled']) ?>
                            </div>
                            <?php if($model->id) {?>
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'tot_sem_desconto')->widget(MaskMoney::classname(), [
                                        'options' => ['readOnly' => 'true'],
                                        'pluginOptions' => [
                                            'prefix' => 'R$ ',
                                            'suffix' => '',
                                            'allowNegative' => false,
                                            'id' => 'total',
                                            'name' => 'total',
                                        ],
                                    ])->label('Total: ');
                                    ?>
                                </div>
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'desconto')->widget(MaskMoney::classname(), [
                                        'pluginOptions' => [
                                            'prefix' => 'R$ ',
                                            'suffix' => '',
                                            'allowNegative' => false,
                                            'id' => 'desconto',
                                            'name' => 'desconto',
                                        ],
                                    ])->label('Desconto: ');
                                    ?>
                                </div>
                                <?php if($model->form_pagamento == '0'){?>
                                    <div class="col-sm-12">
                                        <?= $form->field($model, 'form_pagamento')
                                            ->dropDownList(['0' => 'Pago', '1' => 'À prazo'], ['disabled' => 'true'])
                                            ->label('Pagamento: '); ?>
                                    </div>
                                <?php } else {?>
                                    <div class="col-sm-12">
                                        <?= $form->field($model, 'form_pagamento')
                                            ->dropDownList(['0' => 'Recebido', '1' => 'Aguardando Pagamento'])
                                            ->label('Pagamento: '); ?>
                                    </div>
                                <?php }?>
                            <?php }
                            if(!$model->id){
                                ?>
                                <?= Html::submitButton('Prosseguir', ['class' => 'btn btn-success btn-flat pull-right', 'data' => [
                                    'confirm' => "Prosseguir com a Venda?",
                                    'method' => 'post',
                                ]]) ?>
                                <?= Html::a('Voltar', ['site/index'], ['class' => 'btn btn-warning btn-flat']) ?>
                                <?php ActiveForm::end(); ?>
                            <?php }else {?>
                                <?= Html::submitButton('Confirmar', ['class' => 'btn btn-success btn-flat pull-right', 'data' => [
                                    'confirm' => "Finalizar venda?",
                                    'method' => 'post',
                                ]]) ?>
                                <?= Html::a('Cancelar a venda', ['delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger btn-flat',
                                    'data' => [
                                        'confirm' => 'Deseja realmente excluir a venda?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                                <?php ActiveForm::end(); ?>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }?>


