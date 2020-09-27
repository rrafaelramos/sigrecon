<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Nova Senha';

?>

<?php
    $aux1 = $model->nome;
    $aux = explode(" ",$aux1);
    $nome = $aux[0];
?>
<?php $form = ActiveForm::begin(['action' => ['usuario/salva-senha', 'id' => $model->id]]); ?>
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>SIGRE</b>con</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">

        <p class="login-box-msg">Olá <?php echo $nome;?>!<br> Informe Sua Nova Senha:</p>
        <?= $form->field($model, 'password')->passwordInput()->label('Senha')?>

        <div class="row">

            <div class="col-xs-4">
                <?= Html::submitButton('Salvar',['class' => 'btn btn-success btn-flat pull-right', 'data' => [
                    'confirm' => "Deseja realmente salvar?",
                    'method' => 'post',
                ]]) ?>

            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
    <!--    --><?php //}?>
</div><!-- /.login-box -->