<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Rais */

$this->title = 'Create Rais';
$this->params['breadcrumbs'][] = ['label' => 'Rais', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rais-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
