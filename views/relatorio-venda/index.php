<?php

use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Usuario;
use app\models\Contabilidade;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RelatorioVendaFuncionario */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Relatório de Venda';
$this->params['breadcrumbs'][] = $this->title;
?>
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
<div class="venda-form col-sm-12">
    <div class="venda-form box box-primary">
        <div class="box-body table-responsive col-sm-11">
            <div class="col-sm-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Relatório de Produtividade</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        $form = ActiveForm::begin([
                            'action' => ['relatorio'],
                            'method' => 'post',
                        ]);
                        ?>
                        <div class="col-sm-3">
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
                        </div>
                        <div class="col-sm-3">
                            <?= $form->field($model, 'fim')->widget(DateControl::classname(), [
                                'type'=>DateControl::FORMAT_DATE,
                                'widgetOptions' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'php:d/m/Y'
                                    ]
                                ],
                                'language' => 'pt-BR'
                            ]);
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'colaborador')->dropDownList(ArrayHelper::map(Usuario::find()->all(),'id','nome'),['prompt' => 'Todos']) ?>
                        </div>
                        <div class="col-sm-12">

                            <?= Html::submitButton('Gerar', ['class' => 'btn btn-success btn-flat pull-right']) ?>

                            <?= Html::a('Cancelar', ['/site/index'], ['class' => 'btn btn-warning btn-flat']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>