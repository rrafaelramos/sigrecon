<?php

use app\models\Fcaixa;
use kartik\datecontrol\DateControl;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Fcaixa */
/* @var $form yii\widgets\ActiveForm */
?>
<?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->tipo == '1'){
$data = 0;
function verificaFechamento(){
    $todos = Fcaixa::find()->all();
    if($todos){
        $fechamento = Fcaixa::find()->max('id');
        foreach ($todos as $t){
            if($t->id == $fechamento){
//                $data = str_replace("00:00:00", "",$t->data_fechamento);
                $dataf = explode(" ",$t->data_fechamento);

                $hora = $dataf[1];

                $aux = $dataf[0];
                $ano_ymd = explode("-",$aux);
                $ano = $ano_ymd[0];
                $mes = $ano_ymd[1];
                $dia = $ano_ymd[2];
                return "<p class='text-justify'>Serão contabilizados todas as movimentações financeiras desde o último fechamento em:</p><center>$dia/$mes/$ano às $hora</center>";
            }
        }
    }else
    return "<center>Primeiro fechamento do Caixa</center>";
}
?>

<div class="venda-form col-sm-12">
    <div class="venda-form box box-primary">
        <?php $form = ActiveForm::begin(); ?>
        <div class="box-body table-responsive col-sm-8">
            <div class="col-lg-offset-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Fechar Caixa</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                           <h4> <?php echo verificaFechamento(); ?> </h4>
                            <?= $form->field($model, 'data_fechamento')->textInput(['type' => 'hidden'])->label('')?>
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
                            <?= Html::submitButton('Fechar Caixa',['class' => 'btn btn-success btn-flat pull-right', 'data' => [
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

<?php } else{
    echo '<center><div class="col-sm-4 col-sm-offset-4">';
    echo Alert::widget([
        'options' => [
            'class' => 'alert-warning',
        ],
        'body' => 'Acesso negado! <br>Contate o Gerente',
    ]);
    echo Html::a(
        '<span class=""></span> Voltar',
        ['/site/index'],
        ['data-method' => 'post', 'class' => 'btn btn-success btn-flat']
    );
    echo '<center></div>';
}
?>