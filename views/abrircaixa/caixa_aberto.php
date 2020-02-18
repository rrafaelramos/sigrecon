<?php

use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Abrircaixa */

$this->title = 'Abrir Caixa';
$this->params['breadcrumbs'][] = ['label' => 'Abrir Caixas'];
?>

<div class="abrircaixa-view box box-primary">
    <div class="box-header">
    </div>
    <div class="box-body table-responsive">
        <div class="col-sm-12">
            <div class="col-sm-6 col-sm-offset-3">
                <?php
                echo Alert::widget([
                    'options' => [
                        'class' => 'alert-warning',
                    ],
                    'body' => "<h3><center>".'O caixa já está aberto!'."</center></h3>",
                ]);
                ?>
            </div>
        </div>
        <div class="col-sm-12">
            <?= Html::a('Início', ['/site/index'], ['class' => 'btn btn-success btn-flat pull-right']) ?>
        </div>
    </div>
</div>
