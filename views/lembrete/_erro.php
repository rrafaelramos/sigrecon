<?php

use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;


/* @var $this yii\web\View */
/* @var $model app\models\Lembrete */
/* @var $form yii\widgets\ActiveForm */
?>
<?php

$this->title = 'Compromissos';
$this->params['breadcrumbs'][] = $this->title;

function auxiliar($data){
    $dataaux = explode('-',$data);
    $dia = $dataaux[2];
    $mes = $dataaux[1];
    $ano = $dataaux[0];
    return "$dia/$mes/$ano";
}
?>

<div class="lembrete-form box box-primary ">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive col-sm-6 col-sm-offset-3">
        <!--        --><?php
        //        echo '<h1><center>'.auxiliar($model->data).'</center></h1>';
        //        ?>
        <div>
            <?= $form->field($model, 'data')->widget(DateControl::classname(), [
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
        <?= $form->field($model, 'titulo')->textInput(['maxlength' => true])->label('Lembre-me de:') ?>

        <!--        --><?php //echo $form->field($model, 'usuario_fk')->textInput() ?>
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success btn-flat pull-right']) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-warning btn-flat']) ?>
    </div>

    <div class="box-footer">
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php

echo '<center><div class="col-sm-4 col-sm-offset-4">';

echo Alert::widget([
    'options' => [
        'class' => 'alert-warning',
    ],
    'body' => 'A data não pode ser retroativa!',
]);
echo '<center></div>';
?>
