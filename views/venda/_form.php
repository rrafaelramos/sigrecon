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
//$this->registerJs('
//    $(document).on("blur","#quantidade",function(){
//        var quantidade = $("#quantidade").val();
//            var total = quantidade*2;
//            alert(total);
//    });
//');
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
                                <?= $form->field($model, 'cliente_fk')->dropDownList(ArrayHelper::map(Clienteavulso::find()->all(), 'id', 'nome'), ['prompt' => 'Selecione'], ['readOnly' => 'true'])->label('Nome do Cliente');?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'servico_fk')->dropDownList(ArrayHelper::map(Servico::find()->all(),'id', 'descricao'),['prompt' => 'Selecione', 'id' => 'servico'])?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'quantidade')->textInput([ 'type' => 'number', 'id' => 'quantidade', 'default' => '1', 'value' => '1', 'min' => '1']) ?>
                            </div>

                            <?php if($model->id) {?>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'tot_sem_desconto')->widget(MaskMoney::classname(), [
                                    'options' => ['readOnly' => 'true'],
                                    'pluginOptions' => [
                                        'prefix' => 'R$ ',
                                        'suffix' => '',
                                        'allowNegative' => false,
                                        'id' => 'tot_sem_desconto',
                                        'name' => 'tot_sem_desconto',
                                    ]
                                ]);
                                ?>
                            </div>
                                <div class="col-sm-12">
                                    <div class="col-sm-6">
                                        <?= $form->field($model, 'desconto')->widget(MaskMoney::classname(), [
//                                        'options' => ['readOnly' => 'true'],
                                            'pluginOptions' => [
                                                'prefix' => 'R$ ',
                                                'suffix' => '',
                                                'allowNegative' => false,
                                                'id' => 'desconto',
                                                'name' => 'desconto',
                                            ]
                                        ]);
                                        ?>
                                    </div>
                                </div>
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
                                    'confirm' => "Valor Adicionado ao Caixa!",
                                    'method' => 'post',
                                ]]) ?>

                                <?= Html::a('Cancelar venda', ['delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger btn-flat',
                                    'data' => [
                                        'confirm' => 'Deseja realmente cancelar a Venda?',
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


