<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = 'Editar';
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
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
