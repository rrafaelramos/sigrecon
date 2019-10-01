<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Clienteavulso */

$this->title = 'Cadastrar Cliente';
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clienteavulso-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
