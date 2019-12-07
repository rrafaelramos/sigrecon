<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Servico */

$this->title = 'Cadastrar Serviço';
$this->params['breadcrumbs'][] = ['label' => 'Serviços', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servico-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
