<?php

/* @var $this yii\web\View */

use app\models\Contabilidade;
use yii\helpers\Html;

$this->title = 'SIGRECon';
date_default_timezone_set('America/Sao_Paulo');
?>
<div class="site-index">

    <div class="jumbotron">
        <?php
        if(!Yii::$app->user->isGuest) {
            if (!Contabilidade::find()->all() && Yii::$app->user->identity->tipo==1) {
                echo '<h2>Bem vindo ao SIGRECon!</h2><br>'.
                    '<h2>Clique no botão abaixo para configurar com os dados da contabilidade<br><h1>';
                echo
                Html::a(
                    '<span class="fa fa-gear"></span> Configurar',
                    ['/contabilidade/create'],
                    ['data-method' => 'post', 'class' => 'btn btn-success btn-flat']
                );
            } else {
                echo '<h1><b>SIGRE</b>Con</h1>';
                echo '<p class="lead">Bem vindo! </p>';
            }
        }else{
            echo '<h1><b>SIGRE</b>Con</h1>';
        }
        ?>

    </div>
</div>
