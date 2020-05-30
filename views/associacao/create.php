<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Associacao */

$this->title = 'Cadastrar Associacao';
$this->params['breadcrumbs'][] = ['label' => 'Associacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="associacao-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
