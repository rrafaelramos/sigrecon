<?php

use app\models\Alertaservico;
use app\models\Avisa_rotina;
use app\models\Caixa;
use app\models\Empresa;
use app\models\Rotina;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<?php
date_default_timezone_set('America/Sao_Paulo');

//essa funão verifica se deverá ser gerado protocolo de entrega nesse mês
function mensal(){
    // todo mes os sistema vai gerar o relatório de entrega, e no dia especifico do aviso vai me mostar;
    $data = date('Y-m-d');
    $dataform = explode("-",$data);
    $mesatual = $dataform[1];
    $anoatual = $dataform[0];

    $rotinas = Rotina::find()->all();
    $empresas = Empresa::find()->all();
    $avisarotina = Avisa_rotina::find()->all();

    $mes_tabela = '00';
    $numeroempresa = count($empresas);
    $numerorotina = count($rotinas);
    //cria um array para ir setando as empresas que se encaixam na rotina mensal
    $arrayempresa = array();
    //cria um array para ir setando as rotinas que se encaixam na rotina mensal
    $arrayrotina = array();
    $cont=0;
    $cont2=0;
    //pegar o nome da rotina
//    for($i=0; $i<$numerorotina; $i++){
//        if(strtotime($rotinas[$i]->data_aviso) == strtotime($data)){
//            $arrayrotina[$cont] = $rotinas[$i];
//            $cont++;
//        }
//    }

    //pegar ultima data das rotinas geradas;
    $data_tabela = Avisa_rotina::find()->max('gera_auto');
    if(!$data_tabela) {
        $mes_tabela = '00';
    }else{
        $d_tabela = explode("-", $data_tabela);
        $mes_tabela = $d_tabela[1];
        $ano_tabela = $d_tabela[0];
    }

    //verifica o mes atual e o ultimo mes salvo para gerar novo "avisa_rotina"
    if ($mesatual != $mes_tabela){
        // cria um array com as empresas da rotina mensal e sua respectiva rotina
        for($i=0; $i<$numeroempresa; $i++) {
            for ($j = 0; $j < $numerorotina; $j++) {
                //verifica todas as empresas que possuem a rotina mensal;
                if (($empresas[$i]->rotina == $rotinas[$j]->id) && $rotinas[$j]->repeticao == 1) {
                    $arrayempresa[$cont2] = $empresas[$i];
                    $cont2++;
                }
            }
        }

        $aux = 0;
        $dataaux = 0;
        $dia = $dataaux[2];
        $ano = $dataaux[0];
        //salva as empresas no model
        if($arrayempresa){
            do {
                $model_avisa = new Avisa_rotina();
                $model_avisa->empresa_fk = $arrayempresa[$aux]->id;
                $model_avisa->rotina_fk = $arrayempresa[$aux]->rotina;
                foreach ($rotinas as $r){
                    if($model_avisa->rotina_fk == $r->id){
                        $dataaux = explode("-", $r->data_entrega);
                        $dia = $dataaux[2];
                        $ano = $dataaux[0];
                    }
                }
                $model_avisa->data_entrega = "$anoatual-$mesatual-$dia";
                $model_avisa->gera_auto = $data;
                $model_avisa->status_chegada = 0;
                $model_avisa->status_entrega = 0;
                $model_avisa->save();
                $aux++;
            }while($aux < $cont2);
            return 1;
        }else{
            return 0;
        }
    }
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
// retorna o número de servicos pendentes
function servicoPendente(){
    $cont = 0;

    $alerta = Alertaservico::find()->all();

    foreach ($alerta as $a){
        if($a->status_servico == 0  && Yii::$app->user->identity->id == $a->usuario_fk){
            $cont++;
        }
    }
    if($cont>1) {
        return " $cont serviços pendentes!";
    }elseif($cont == 1){
        return " $cont serviço pendente!";
    }else{
        return 0;
    }
}
// retorna o número de servicos/pf prontos para entrega
function servicoPronto(){
    $cont = 0;

    $alerta = Alertaservico::find()->all();

    foreach ($alerta as $a){
        if($a->status_servico == 1  && Yii::$app->user->identity->id == $a->usuario_fk){
            $cont++;
        }
    }
    if($cont>1) {
        return " $cont serviços prontos para entrega!";
    }elseif($cont == 1){
        return " $cont serviço pronto para entrega!";
    }else{
        return 0;
    }
}
//verifica se o caixa está fechado
function caixa(){
    // se o numero de estado 1 for == total de inserções no caixa então o caixa está fechado
    $caixa = Caixa::find()->all();
    $cont = count($caixa);
    $cont2 =0;
    foreach ($caixa as $c){
        if($c->estado == 1 ){
            $cont2++;
        }
    }
    if($cont == $cont2){
        return 1;
    }
    return 0;
}


//verifica guias rotina que não foram recebidas para realizar o serviço
function rotinaAguardando(){
    $avisa_rotina = Avisa_rotina::find()->all();
    $aguardando = array();
    $cont = 0;
    foreach ($avisa_rotina as $a){
        if(!$a->status_chegada){
            $aguardando[$cont] = $a->empresa_fk;
            $cont++;
        }
    }
    if($cont > 1){
        return "Aguardando doc. de $cont empresas!";
    }elseif($cont==1){
        return "Aguardando doc. de $cont empresa!";
    }
}
//verifica o número de guias q não foram entregue
function rotinaPronto(){
    $avisa_rotina = Avisa_rotina::find()->all();
    $cont = 0;
    foreach ($avisa_rotina as $a){
        if($a->data_pronto && !$a->data_entregue){
            $cont++;
        }
    }
    if($cont){
        return "$cont doc. pronto para entrega!";
    }
    return 0;
}
//verifica o número de guias pendentes
function rotinaPendente(){
    $avisa_rotina = Avisa_rotina::find()->all();
    $cont = 0;
    foreach ($avisa_rotina as $a){
        if($a->status_entrega == 0){
            $cont++;
        }
    }
    if($cont){
        return "$cont guias pendentes";
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
                <!--                Verifica se tem um usuário Logado!-->
                <?php
                if(!Yii::$app->user->isGuest){
                    ?>
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

                    <?php if (caixa()){
                        echo
                        '<li class="dropdown notifications-menu">
                        <a href="/sigrecon/web/?r=abrircaixa/create"> Abrir Caixa
                            <i class="fa fa-usd">
                            </i>
                            <span class="label label-warning">';
                        echo
                        '</a>
                    </li>';
                    }?>

                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!--                        //class warning para nova notificação-->
                            <?php
                            if(certificado() || procuracao() || servicoPronto() || servicoPendente()){
                                echo '<i class="fa fa-bell"></i>'.'<span class="label label-warning">';
                                echo '!';
                            }else{
                                echo '<i class="fa fa-bell-o"></i>';
                            }
                            ?>
                            </span>
                        </a>

                        <ul class="dropdown-menu">
                            <li class="header">
                            </li>
                            <?php
                            echo '<center>'."Notificações de serviços".'</center>';
                            ?>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li>
                                        <?php
                                        if(servicoPronto()) {
                                            echo '<a href="/sigrecon/web/?r=alertaservico/pronto"> <i class="fa fa-check-circle text-green"></i>'.servicoPronto().'</a>';
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        if(certificado()) {
                                            echo '<a href="/sigrecon/web/?r=empresa/datavenc"> <i class="fa fa-warning text-yellow"></i>'.certificado().'</a>';
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        if(procuracao()) {
                                            echo '<a href="/sigrecon/web/?r=empresa/datavenc"> <i class="fa fa-warning text-yellow"></i>'.procuracao().'</a>';
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        if(servicoPendente()) {
                                            echo '<a href="/sigrecon/web/?r=alertaservico/pendente"> <i class="fa fa-warning text-yellow"></i>'.servicoPendente().'</a>';
                                        }
                                        ?>
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


                    <li class="dropdown notifications-menu">
                        <!-- ISSO DEFINE O QUE FICA NO HEADEAR-->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!--                        //class warning para nova notificação-->
                            <?php
                            mensal();
                            if(rotinaAguardando()|| rotinaPronto() || rotinaPendente()){
                                echo '<i class="fa fa-flag"></i>'.'<span class="label label-warning">';
                                echo '!';
                            }else {
                                echo '<i class="fa fa-flag-o"></i>';
                            }
                            ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">
                                <?php
                                echo '<center>'."Notificações de rotinas".'</center>';
                                ?>
                            </li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li>
                                        <?php
                                        if(rotinaPronto()) {
                                            echo '<a href="/sigrecon/web/?r=avisa_rotina/pronto"> <i class="fa fa-check-circle text-green"></i>'.rotinaPronto().'</a>';
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        if(rotinaAguardando()) {
                                            echo '<a href="/sigrecon/web/?r=avisa_rotina/aguardando"> <i class="fa fa-warning text-yellow"></i>'.rotinaAguardando().'</a>';
                                        }else{
                                            echo '<a> <i class="fa fa-check-circle text-green"></i>'."Nenhum documento sendo aguardado".'</a>';
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        if(rotinaPendente()) {
                                            echo '<a href="/sigrecon/web/?r=avisa_rotina/pendente"> <i class="fa fa-warning text-yellow"></i>'.rotinaPendente().'</a>';
                                        }
                                        ?>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="/sigrecon/web/?r=avisa_rotina">Ver todos</a></li>
                        </ul>
                    </li>



                    <!--                    <li class="dropdown tasks-menu">-->
                    <!--                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">-->
                    <!--                            <i class="fa fa-flag-o"></i>-->
                    <!--                            <span class="label label-danger">9</span>-->
                    <!--                        </a>-->
                    <!--                        <ul class="dropdown-menu">-->
                    <!--                            <li class="header">You have 9 tasks</li>-->
                    <!--                            <li>-->
                    <!--                                -->
                    <!--                                <ul class="menu">-->
                    <!--                                    <li>-->
                    <!--                                        <a href="#">-->
                    <!--                                            <h3>-->
                    <!--                                                Design some buttons-->
                    <!--                                                <small class="pull-right">20%</small>-->
                    <!--                                            </h3>-->
                    <!--                                            <div class="progress xs">-->
                    <!--                                                <div class="progress-bar progress-bar-aqua" style="width: 20%"-->
                    <!--                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"-->
                    <!--                                                     aria-valuemax="100">-->
                    <!--                                                    <span class="sr-only">20% Complete</span>-->
                    <!--                                                </div>-->
                    <!--                                            </div>-->
                    <!--                                        </a>-->
                    <!--                                    </li>-->
                    <!--                                    -->
                    <!--                                    <li>-->
                    <!--                                        <a href="#">-->
                    <!--                                            <h3>-->
                    <!--                                                Create a nice theme-->
                    <!--                                                <small class="pull-right">40%</small>-->
                    <!--                                            </h3>-->
                    <!--                                            <div class="progress xs">-->
                    <!--                                                <div class="progress-bar progress-bar-green" style="width: 40%"-->
                    <!--                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"-->
                    <!--                                                     aria-valuemax="100">-->
                    <!--                                                    <span class="sr-only">40% Complete</span>-->
                    <!--                                                </div>-->
                    <!--                                            </div>-->
                    <!--                                        </a>-->
                    <!--                                    </li>-->
                    <!--                                -->
                    <!--                                    <li>-->
                    <!--                                        <a href="#">-->
                    <!--                                            <h3>-->
                    <!--                                                Some task I need to do-->
                    <!--                                                <small class="pull-right">60%</small>-->
                    <!--                                            </h3>-->
                    <!--                                            <div class="progress xs">-->
                    <!--                                                <div class="progress-bar progress-bar-red" style="width: 60%"-->
                    <!--                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"-->
                    <!--                                                     aria-valuemax="100">-->
                    <!--                                                    <span class="sr-only">60% Complete</span>-->
                    <!--                                                </div>-->
                    <!--                                            </div>-->
                    <!--                                        </a>-->
                    <!--                                    </li>-->
                    <!--                                   -->
                    <!--                                    <li>-->
                    <!--                                        <a href="#">-->
                    <!--                                            <h3>-->
                    <!--                                                Make beautiful transitions-->
                    <!--                                                <small class="pull-right">80%</small>-->
                    <!--                                            </h3>-->
                    <!--                                            <div class="progress xs">-->
                    <!--                                                <div class="progress-bar progress-bar-yellow" style="width: 80%"-->
                    <!--                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"-->
                    <!--                                                     aria-valuemax="100">-->
                    <!--                                                    <span class="sr-only">80% Complete</span>-->
                    <!--                                                </div>-->
                    <!--                                            </div>-->
                    <!--                                        </a>-->
                    <!--                                    </li>-->
                    <!--                                    -->
                    <!--                                </ul>-->
                    <!--                            </li>-->
                    <!--                            <li class="footer">-->
                    <!--                                <a href="#">View all tasks</a>-->
                    <!--                            </li>-->
                    <!--                        </ul>-->
                    <!--                    </li>-->

                <?php } ?>
                <!-- User Account: style can be found in dropdown.less -->

                <!--                Se o usuário não estiver logado apresenta o botão login-->
                <?php if (Yii::$app->user->isGuest){
                    ?>
                    <li class="dropdown user user-menu">
                        <?= Html::a('Entrar', ['site/login']) ?>
                    </li>
                    <li class="dropdown user user-menu">
                        <?= Html::a('Cadastrar', ['site/signup']) ?>
                    </li>
                <?php }else{  ?>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                            <span class="hidden-xs"><?= Yii::$app->user->identity->nome?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle"
                                     alt="User Image"/>

                                <p>
                                    <?= Yii::$app->user->identity->email;
                                    date_default_timezone_set('America/Sao_Paulo');
                                    $data = date('d/m/Y');
                                    ?>
                                    <small>Seja Bem Vindo!<br> <?php echo $data;?></small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <!--                        <li class="user-body">-->
                            <!--                            <div class="col-xs-4 text-center">-->
                            <!--                                <a href="#">Followers</a>-->
                            <!--                            </div>-->
                            <!--                            <div class="col-xs-4 text-center">-->
                            <!--                                <a href="#">Sales</a>-->
                            <!--                            </div>-->
                            <!--                            <div class="col-xs-4 text-center">-->
                            <!--                                <a href="#">Friends</a>-->
                            <!--                            </div>-->
                            <!--                        </li>-->
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <?= Html::a(
                                        'Sair',
                                        ['/site/logout'],
                                        ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                    ) ?>
                                </div>
                            </li>
                        </ul>
                    </li>
                <?php }?>

                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
