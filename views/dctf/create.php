<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Dctf */

$this->title = 'Create Dctf';
$this->params['breadcrumbs'][] = ['label' => 'Dctfs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dctf-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
