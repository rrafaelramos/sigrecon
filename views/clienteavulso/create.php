<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Clienteavulso */

$this->title = 'Create Clienteavulso';
$this->params['breadcrumbs'][] = ['label' => 'Clienteavulsos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clienteavulso-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
