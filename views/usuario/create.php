<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = 'Cadastrar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
