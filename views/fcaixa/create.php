<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Fcaixa */

$this->title = 'Fechar o Caixa';
$this->params['breadcrumbs'][] = ['label' => 'Fechar caixa', 'url' => ['index']];

?>
<div class="fcaixa-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
