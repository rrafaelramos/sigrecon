<?php

use app\models\Associacao;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ecf */
/* @var $form yii\widgets\ActiveForm */

function buscacnpj($associacao_id){
    $asso = Associacao::find()->all();
    foreach ($asso as $assoc){
        if ($assoc->id == $associacao_id){
            return $assoc->cnpj;
        }
    }
}
?>

<div class="ecf-form col-sm-12">
    <div class="ecf-form box box-primary">
        <?php $form = ActiveForm::begin(); ?>
        <div class="box-body table-responsive col-sm-11">
            <div class="col-lg-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">ECF</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-9">
                            <?= $form->field($model, 'associacao_nome')->textInput(['type'=>'text','disabled' => 'disabled'])->label('Associação:') ?>
                        </div>
                        <div class="col-sm-3">
                            <?= $form->field($model, 'feito')->dropDownList(['Não' => 'Não',
                                'Sim' => 'Sim'])->label('Está pronto?') ?>
                        </div>
                        <div class="col-sm-12">
                            <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-warning btn-flat pull-left']) ?>
                            <?= Html::submitButton('Atualizar', ['class' => 'btn btn-success btn-flat pull-right', 'data' => [
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

