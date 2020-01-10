<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Mensagem */

$this->title = 'Novo Recado';
$this->params['breadcrumbs'][] = ['label' => 'Recados', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'novo';
?>
<div class="mensagem-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
