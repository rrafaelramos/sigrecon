<?php

use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Abrircaixa */

$this->title = 'Abrir Caixa';
$this->params['breadcrumbs'][] = ['label' => 'Abrir Caixas'];
?>

<?php
    function formatar($model){
        $formatter = Yii::$app->formatter;
        if($model) {
            $formatado = $formatter->asDecimal($model, 2);
            $valor = "R$ ".$formatado;
            return $valor;
        }else
        return 'R$ 0,00';
    }
?>

<div class="abrircaixa-view box box-primary">
    <div class="box-header">
        <div class="col-sm-6">
            <?= Html::a('Alterar Valor', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat pull-left']) ?>
        </div>
        <div class="col-sm-6">
            <?= Html::a('Início', ['/site/index'], ['class' => 'btn btn-success btn-flat pull-right']) ?>
        </div>
    </div>
    <div class="box-body table-responsive">
        <div class="col-sm-12">
            <div class="col-sm-6 col-sm-offset-3">
                <?php
                echo Alert::widget([
                    'options' => [
                        'class' => 'alert-warning',
                    ],
                    'body' => "<h3><center>".formatar($model->valor).' Adicionado ao Caixa!'."</center></h3>",
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
