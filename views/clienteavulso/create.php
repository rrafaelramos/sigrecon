<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Clienteavulso */

$this->title = 'Cadastrar Cliente Avulso';
$this->params['breadcrumbs'][] = ['label' => 'Cadastrar Cliente', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clienteavulso-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
