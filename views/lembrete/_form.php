<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Lembrete */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
function auxiliar($data){
    $dataaux = explode('-',$data);
    $dia = $dataaux[2];
    $mes = $dataaux[1];
    $ano = $dataaux[0];
    return "$dia/$mes/$ano";
}
?>

<div class="lembrete-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?php
        echo '<h1><center>'.auxiliar($model->data).'</center></h1>';
        ?>

        <?= $form->field($model, 'titulo')->textInput(['maxlength' => true])->label('Lembre-me de:') ?>

        <!--        --><?php //echo $form->field($model, 'usuario_fk')->textInput() ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success btn-flat pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
