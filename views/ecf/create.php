<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ecf */

$this->title = 'Cadastrar ECF';
$this->params['breadcrumbs'][] = ['label' => 'Ecfs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ecf-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
