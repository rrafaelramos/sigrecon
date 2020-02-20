<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
///* @var $this yii\web\View */
///* @var $model app\models\Fcaixa */
/* @var $valor app\controllers\FcaixaController */

$this->title = "Saldo";
?>

<?php
function formatar($valor){
    if (!$valor){
        return "R$ 0,00";
    }
    $formatter = Yii::$app->formatter;
    $formatado = $formatter->asCurrency($valor);
    $dinheiro = str_replace("pt-br", "R$", $formatado);
    return $dinheiro;
}
?>

<div class="col-sm-12">
    <div class="col-sm-offset-4">
        <div class="clienteavulso-form col-sm-6">
            <div class="empresa-view box box-primary">
                <div class="panel-body">
                    <div class="panel-group collapse in">
                        <div class="panel panel-default">
                            <div class="panel-heading with-border col-sm-12">
                                <div class="col-sm-12">
                                    <center> <h4><?php echo "Saldo Disponível";?></h4></center>
                                </div>
                            </div>
                            <div class="box-body table-responsive">
                                <center><h4><?php echo formatar($valor);?></h4></center>
                            </div>
                        </div>
                    </div>
                    <div>
                        <?= Html::a('Fechar caixa', ['/fcaixa/create'],[ 'class' => 'btn btn-danger btn-flat pull-left']) ?>
                        <?= Html::a('Início', ['/site/index'],[ 'class' => 'btn btn-primary btn-flat pull-right']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
