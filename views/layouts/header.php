<?php

use app\models\Empresa;
use app\models\Rotina;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<?php
date_default_timezone_set('America/Sao_Paulo');

function mensal(){
    $data = date('Y-m-d');
    $rotinas = Rotina::find()->all();
    $empresas = Empresa::find()->all();
    $numeroempresa = count($empresas);
    $numerorotina = count($rotinas);
    //cria um array para ir setando as empresas que se encaixam na rotina mensal
    $arrayempresa = array();
    //cria um array para ir setando as rotinas que se encaixam na rotina mensal
    $arrayrotina = array();
    $cont=0;
    $cont2=0;
    //pegar o nome da rotina
    for($i=0; $i<$numerorotina; $i++){
        if(strtotime($rotinas[$i]->data_aviso) == strtotime($data)){
            $arrayrotina[$cont] = $rotinas[$i];
            $cont++;
        }
    }
    for($i=0; $i<$numeroempresa; $i++){
        for($j=0; $j<$numerorotina; $j++) {
            //verifica todas as empresas que possuem a rotina mensal;
            if (($empresas[$i]->rotina == $rotinas[$j]->id) && $rotinas[$j]->repeticao == 1) {
                $arrayempresa[$cont2] = $empresas[$i];
                $cont2++;
            }
        }
    }
    return $cont;
}

// retorna o número de certificados que irão expirar no dia!
function certificado(){
    $data = date('Y-m-d');
    $empresas = Empresa::find()->all();
    $arrayempresa = array();
    $cont = 0;
    foreach ($empresas as $emp){
        if($emp->data_certificado == $data){
            $arrayempresa[$cont] = $emp->id;
            $cont++;
        }
    }
    if($cont>1){
        return "   $cont Certificados expiram hoje!";
    }elseif ($cont==1){
        return "   $cont certificado expira hoje!";
    }else{
        return 0;
    }
}
//retorna o número de procuracao que irão expirar no dia!
function procuracao(){
    $data = date('Y-m-d');
    $empresas = Empresa::find()->all();
    $arrayempresa = array();
    $cont = 0;
    foreach ($empresas as $emp){
        if($emp->data_procuracao == $data){
            $arrayempresa[$cont] = $emp->id;
            $cont++;
        }
    }
    if($cont>1){
        return "   $cont procurações expiram hoje!";
    }elseif ($cont==1){
        return "   $cont procuração expira hoje!";
    }else{
        return 0;
    }
}
?>


<header class="main-header">

    <?= Html::a('<span class="logo-mini"><b>SG</b>C</span><span class="logo-lg"><b>SIGRE</b>Con</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>


    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 3 messages</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle"
                                                 alt="User Image"/>
                                        </div>
                                        <h4>
                                            Support Team
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <!-- end message -->
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?= $directoryAsset ?>/img/user3-128x128.jpg" class="img-circle"
                                                 alt="user image"/>
                                        </div>
                                        <h4>
                                            AdminLTE Design Team
                                            <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?= $directoryAsset ?>/img/user4-128x128.jpg" class="img-circle"
                                                 alt="user image"/>
                                        </div>
                                        <h4>
                                            Developers
                                            <small><i class="fa fa-clock-o"></i> Today</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?= $directoryAsset ?>/img/user3-128x128.jpg" class="img-circle"
                                                 alt="user image"/>
                                        </div>
                                        <h4>
                                            Sales Department
                                            <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="<?= $directoryAsset ?>/img/user4-128x128.jpg" class="img-circle"
                                                 alt="user image"/>
                                        </div>
                                        <h4>
                                            Reviewers
                                            <small><i class="fa fa-clock-o"></i> 2 days</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                </li>

                <li class="dropdown notifications-menu">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">
                            <?php
                            if(certificado() || procuracao()){
                                echo '!';
                            }
                            echo '';
                            ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">
                            <?php
                            $verifica = mensal();
                            echo "Notificações: $verifica";
                            ////                            if($command){
                            ////                                return 'deu certo';
                            //                            }
                            ?>
                        </li>

                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                    </a>
                                </li>
                                <li>
                                    <!--                                    <i class="fa fa-warning text-yellow"></i>-->
                                    <!--                                    <i class="fa fa-warning "></i>-->
                                    <?php
                                    if(certificado()) {
                                        echo Html::a(certificado(), ['/empresa/datavenc'], ['i class' => 'fa fa-warning text-yellow']);
                                    }
                                    ?>
                                </li>
                                <li>
                                    <?php
                                    if(procuracao()) {
                                        echo Html::a(procuracao(), ['/empresa/datavenc'], ['i class' => 'fa fa-warning text-yellow']);
                                    }
                                    ?>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-red"></i> 5 new members joined
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user text-red"></i> You changed your username
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger">9</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 9 tasks</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Design some buttons
                                            <small class="pull-right">20%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                 role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                 aria-valuemax="100">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Create a nice theme
                                            <small class="pull-right">40%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-green" style="width: 40%"
                                                 role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                 aria-valuemax="100">
                                                <span class="sr-only">40% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Some task I need to do
                                            <small class="pull-right">60%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-red" style="width: 60%"
                                                 role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                 aria-valuemax="100">
                                                <span class="sr-only">60% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Make beautiful transitions
                                            <small class="pull-right">80%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-yellow" style="width: 80%"
                                                 role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                 aria-valuemax="100">
                                                <span class="sr-only">80% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#">View all tasks</a>
                        </li>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <span class="hidden-xs">Alexander Pierce</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                Alexander Pierce - Web Developer
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
