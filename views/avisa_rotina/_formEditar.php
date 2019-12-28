<?php

use app\models\Empresa;
use app\models\Rotina;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Avisa_rotina */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
function nome($model){
    $rotinas = Rotina::find()->all();
    foreach ($rotinas as $r){
        if($r->id == $model->rotina_fk){
            return $r->nome;
        }
    }
}
?>


<div class="venda-form col-sm-12">
    <div class="venda-form box box-primary">
        <?php $form = ActiveForm::begin(); ?>
        <div class="box-body table-responsive col-sm-9">
            <div class="col-lg-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo nome($model); ?></h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'empresa_fk')
                                ->dropDownList(ArrayHelper::map(Empresa::find()->all(),'id','razao_social'),['prompt'=>'Selecione', 'disabled' => 'disabled'])
                                ->label('Empresa')?>
                        </div>

                        <div class="col-sm-6">
                            <?= $form->field($model, 'rotina_fk')->dropDownList(ArrayHelper::map(Rotina::find()->all(),'id','nome'),['disabled'=>'disabled'])
                                ->label('Rotina')?>
                        </div>

                        <div class="col-sm-6">
                            <?= $form->field($model, 'data_entrega')->widget(DateControl::classname(), [
                                'type'=>DateControl::FORMAT_DATE,
                                'widgetOptions' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'php:d/m/Y H:i:s',
                                    ]
                                ],'disabled' => 'disabled',
                                'language' => 'pt-BR'
                            ])->label('Data limite para entrega!');
                            ?>
                        </div>

                        <div class="col-sm-6">
                            <?php if($model->status_chegada==0){
                                echo $form->field($model, 'status_chegada')->dropDownList([
                                    'prompt'=> 'Selecione',
                                    '0' => 'Aguardando recebimento',
                                    '1' => 'Recebido'
                                ])->label('Doc. à ser Recebido');
                            }else{
                                echo $form->field($model, 'status_chegada')->dropDownList([
                                    'prompt'=> 'Selecione',
                                    '0' => 'Aguardando recebimento',
                                    '1' => 'Recebido'
                                ],['disabled' => 'disabled'])->label('Doc. à ser Recebido');
                            }
                            ?>
                        </div>

                        <div class="col-sm-6">
                            <?php if($model->status_chegada==1) {
                                echo $form->field($model, 'data_chegada')->widget(DateControl::classname(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'widgetOptions' => [
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'format' => 'php:d/m/Y',
                                        ]
                                    ], 'disabled' => 'disabled',
                                    'language' => 'pt-BR'
                                ])->label('Data recebimento.');
                            }
                            ?>
                        </div>

                        <div class="col-sm-6">
                            <?php
                            if($model->status_entrega == 2){
                                echo $form->field($model, 'status_entrega')->dropDownList([
                                    'prompt'=> 'Selecione',
                                    '0' => 'Pendente',
                                    '1' => 'Pronto para entrega',
                                    '2' => 'Entregue'
                                ],['disabled' => 'disabled']);
                            }else{
                                echo $form->field($model, 'status_entrega')->dropDownList([
                                    'prompt'=> 'Selecione',
                                    '0' => 'Pendente',
                                    '1' => 'Pronto para entrega',
                                    '2' => 'Entregue'
                                ]);
                            }
                            ?>
                        </div>

                        <?php
                        if($model->status_entrega == 1) {
                            echo '<div class="col-sm-6">' .
                                $form->field($model, 'data_pronto')->widget(DateControl::classname(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'widgetOptions' => [
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'format' => 'php:d/m/Y',
                                        ]
                                    ], 'disabled' => 'disabled',
                                    'language' => 'pt-BR'
                                ])->label('Data pronto para entrega');
                            '</div>';
                        }elseif ($model->status_entrega ==2){
                            echo '<div class="col-sm-6">'.
                                $form->field($model, 'data_entregue')->widget(DateControl::classname(), [
                                    'type'=>DateControl::FORMAT_DATE,
                                    'widgetOptions' => [
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'format' => 'php:d/m/Y',
                                        ]
                                    ],'disabled' => 'disabled',
                                    'language' => 'pt-BR'
                                ])->label('Data entregue');

                            '</div>';
                        }
                        ?>
                        <div class="col-sm-12">
                            <?= Html::submitButton('Salvar', ['class' => 'btn btn-success btn-flat pull-right']) ?>
                            <?= Html::a('Voltar',['index'],['class' => 'btn btn-warning btn-flat']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

