<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Avisa_rotina */

$this->title = 'Atualizar';
$this->params['breadcrumbs'][] = ['label' => 'Controle de rotina', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="avisa-rotina-update">

    <?= $this->render('_formEditar', [
        'model' => $model,
    ]) ?>

</div>
