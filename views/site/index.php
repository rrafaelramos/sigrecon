<?php

/* @var $this yii\web\View */

use app\models\Contabilidade;
use yii\helpers\Html;

$this->title = 'SIGRECon';
date_default_timezone_set('America/Sao_Paulo');
$mes = date('m');
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
    <center>
        <div>
            <?php
            if($mes == '04' && !Yii::$app->user->isGuest){
                echo '<h4>Consulte aqui a lista de IRPF para este mês!</h4>';
                echo Html::a(
                    '<span class="fa fa-usd" ></span>  IRPF',
                    ['/irpf'],
                    ['data-method' => 'post', 'class' => 'btn btn-primary btn-flat']
                );
            }
            ?>
        </div>
        <div>
            <?php
            if($mes == '09' && !Yii::$app->user->isGuest){
                echo '<h4>Consulte aqui a lista de ITR para este mês!</h4>';
                echo Html::a(
                    '<span class="fa fa-usd" ></span>  ITR',
                    ['/itr'],
                    ['data-method' => 'post', 'class' => 'btn btn-primary btn-flat']
                );
            }
            ?>
        </div>

        <div>
            <?php
            if($mes == '09' && !Yii::$app->user->isGuest){
                echo '<h4>Consulte aqui a lista de associações para a RAIS deste mês!</h4>';
                echo Html::a(
                    '<span class="fa fa-usd" ></span>  RAIS',
                    ['/rais'],
                    ['data-method' => 'post', 'class' => 'btn btn-primary btn-flat']
                );
            }
            ?>
        </div>

        <div>
            <?php
            if($mes == '03' && !Yii::$app->user->isGuest){
                echo '<h4>Consulte aqui a lista de associações para a DCTF deste mês!</h4>';
                echo Html::a(
                    '<span class="fa fa-usd" ></span>  DCTF',
                    ['/dctf'],
                    ['data-method' => 'post', 'class' => 'btn btn-primary btn-flat']
                );
            }
            ?>
        </div>

        <div>
            <?php
            if($mes == '07' && !Yii::$app->user->isGuest){
                echo '<h4>Consulte aqui a lista de associações para a ECF deste mês!</h4>';
                echo Html::a(
                    '<span class="fa fa-usd" ></span>  ECF',
                    ['/ecf'],
                    ['data-method' => 'post', 'class' => 'btn btn-primary btn-flat']
                );
            }
            ?>
        </div>
    </center>
</div>
