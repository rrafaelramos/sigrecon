<?php

/* @var $this yii\web\View */

use app\models\Usuario;

$this->title = 'SIGRECon';

?>
<div class="site-index">

    <div class="jumbotron">
        <h1><b>SIGRE</b>Con</h1>

        <p class="lead">Seja Bem vindo(a) ao SIGRECon! </p>
        <?php
        $id =Yii::$app->user->id;
        $teste = Usuario::find()->all();
        echo $id;

        ?>





    </div>
</div>
