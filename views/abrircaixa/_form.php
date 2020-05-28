<?php

use kartik\money\MaskMoney;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Abrircaixa */
/* @var $form yii\widgets\ActiveForm */
?>

<?php if((!Yii::$app->user->isGuest) && (Yii::$app->user->identity->tipo == 1)){?>

<div class="clienteavulso-form">
    <div class="clienteavulso-form box box-primary">
        <?php $form = ActiveForm::begin(); ?>
        <div class="box-body table-responsive col-sm-offset-4 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Abrir Caixa</h3>
                </div>
                <div class="panel-body">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'valor')->widget(MaskMoney::classname(), [
                            'pluginOptions' => [
                                'prefix' => 'R$ ',
                                'suffix' => '',
                                'allowNegative' => false,
                                'id' => 'total',
                                'name' => 'total',
                            ]
                        ])->label('Valor de Abertura:');
                        ?>
                    </div>
                    <div>
                        <?= Html::a('Cancelar',['/site/index'], ['class' => 'btn btn-warning btn-flat pull-left'])?>
                        <?= Html::submitButton('Abrir Caixa', ['class' => 'btn btn-success btn-flat pull-right', 'data' => [
                            'confirm' => "Deseja realmente Salvar?",
                            'method' => 'post',
                        ]]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php } else{
    echo '<center><div class="col-sm-4 col-sm-offset-4">';
    echo Alert::widget([
        'options' => [
            'class' => 'alert-warning',
        ],
        'body' => 'Acesso negado! <br>Contate o Gerente',
    ]);
    echo Html::a(
        '<span class=""></span> Sair',
        ['/site/index'],
        ['data-method' => 'post', 'class' => 'btn btn-success btn-flat']
    );
    echo '<center></div>';
}
?>