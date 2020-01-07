<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = 'Update Usuario: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="usuario-update">

    <?php
        // verifica se está concedendo autorização ou se está atualizando seus dados
        // tipo 1 é gerente
        if(Yii::$app->user->identity->tipo == 1 && (Yii::$app->user->identity->email != $model->email)) {
            echo $this->render('_formGerente', [
                'model' => $model,
            ]);
        }else {
            echo $this->render('_form', [
                'model' => $model,
            ]);
        }
    ?>

</div>
