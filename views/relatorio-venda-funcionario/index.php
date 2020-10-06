<?php

use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Usuario;
use app\models\Contabilidade;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $searchModel app\models\RelatorioVendaFuncionario */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Relatório de Venda';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lembrete-form box box-primary ">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive col-sm-6 col-sm-offset-3">
        <div>

            <?php
            if (!Contabilidade::find()->all() && Yii::$app->user->identity->tipo==1) {
                echo '<center><h2>É necessário primeiramente configurar os dados da contabilidade<br><h1>';
                echo
                Html::a(
                    '<span class="fa fa-gear"></span> Configurar',
                    ['/contabilidade/create'],
                    ['data-method' => 'post', 'class' => 'btn btn-success btn-flat']
                );
            } else {

            ?>

            <?php $form = ActiveForm::begin([
                'action' => ['exporta-pdf'],
                'method' => 'post',
            ]); ?>

            <?= $form->field($model, 'inicio')->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATE,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'php:d/m/Y',
                        'name' => 'inicio',
                    ]
                ],
                'language' => 'pt-BR'
            ]); ?>

            <?= $form->field($model, 'fim')->widget(DateControl::classname(), [
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
        <?= $form->field($model, 'colaborador')->dropDownList(ArrayHelper::map(Usuario::find()->all(),'id','nome')) ?>

        <?= Html::submitButton('Gerar', ['class' => 'btn btn-success btn-flat pull-right']) ?>

        <?= Html::a('Cancelar', ['/site/index'], ['class' => 'btn btn-warning btn-flat']) ?>
    </div>

    <div class="box-footer">
    </div>
<?php ActiveForm::end(); ?>
<?php } ?>
</div>
