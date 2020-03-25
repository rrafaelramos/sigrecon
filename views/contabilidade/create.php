<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Contabilidade */

$this->title = 'Create Contabilidade';
$this->params['breadcrumbs'][] = ['label' => 'Contabilidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contabilidade-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
