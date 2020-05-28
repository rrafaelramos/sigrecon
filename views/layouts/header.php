<?php

use app\models\Alertaservico;
use app\models\Alertaservicopj;
use app\models\Avisa_rotina;
use app\models\Caixa;
use app\models\Contabilidade;
use app\models\Empresa;
use app\models\Irpf;
use app\models\Lembrete;
use app\models\Mensagem;
use app\models\Rotina;
use app\models\Usuario;
use app\models\Venda;
use app\models\Vendapj;
use Codeception\Lib\Connector\Yii2;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<?php
date_default_timezone_set('America/Sao_Paulo');
// Verifica se possui novo recado
function recado(){
    $mensagem = Mensagem::find()->all();
    if($mensagem) {
        $cont = 0;
        foreach ($mensagem as $m) {
            if ($m->receptor == Yii::$app->user->identity->id && !$m->lido) {
                $cont++;
            }
        }
        return $cont;
    }else{
        return 0;
    }

}

// verifica pedisdo para se inscrever no sistema
function novoUsuario(){
    $usuario = Usuario::find()->all();
    foreach ($usuario as $u){
        if($u->tipo == 0){
            return 1;
        }
    }
}

//essa função verifica se deverá ser gerado protocolo de entrega das empresas do simples
function simplesNacional()
{
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('Y-m-d');
    $dataform = explode("-", $data);
    $mesatual = $dataform[1];
    $anoatual = $dataform[0];

    $rotinas = Rotina::find()->all();
    $empresas = Empresa::find()->all();

    $mes_tabela = '00';
    $numeroempresa = count($empresas);
    $numerorotina = count($rotinas);
    //cria um array para ir setando as empresas que se encaixam na rotina mensal
    $arrayempresa = array();
    //cria um array para ir setando as rotinas que se encaixam na rotina mensal
    $arrayrotina = array();
    $cont = 0;
    $cont2 = 0;

    //pegar ultima data das rotinas geradas;
    $data_tabela = Avisa_rotina::find()->max('gera_auto');
    if (!$data_tabela) {
        $mes_tabela = '00';
    } else {
        $d_tabela = explode("-", $data_tabela);
        $mes_tabela = $d_tabela[1];
        $ano_tabela = $d_tabela[0];
    }

    //verifica o mes atual e o ultimo mes salvo para gerar novo "avisa_rotina"
    if ($mesatual != $mes_tabela) {
        // cria um array com as empresas da rotina mensal e sua respectiva rotina
        for ($i = 0; $i < $numeroempresa; $i++) {
            for ($j = 0; $j < $numerorotina; $j++) {
                //verifica todas as empresas que possuem a rotina do simples nacional;
                if (($empresas[$i]->rotina == $rotinas[$j]->id) && $rotinas[$j]->nome == 'Simples Nacional') {
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
        if ($arrayempresa) {
            // insere na tabela os DAS
            do {
                $model_avisa = new Avisa_rotina();
                $model_avisa->empresa_fk = $arrayempresa[$aux]->id;
                $model_avisa->rotina_fk = $arrayempresa[$aux]->rotina;
                foreach ($rotinas as $r) {
                    if ($model_avisa->rotina_fk == $r->id) {
                        $dataaux = explode("-", $r->data_entrega);
                        $dia = $dataaux[2];
                        $ano = $dataaux[0];
                    }
                }
                $model_avisa->data_entrega = "$anoatual-$mesatual-$dia";
                $model_avisa->nome_rotina = 'Simples Nacional';
                $model_avisa->gera_auto = $data;
                $model_avisa->status_chegada = 0;
                $model_avisa->status_entrega = 0;
                $model_avisa->save();
                $aux++;
            } while ($aux < $cont2);

            $aux = 0;
            // insere na tabela a DEFIS
            if ($arrayempresa && $mesatual == '03') {
                do {
                    $model_avisa = new Avisa_rotina();
                    $model_avisa->empresa_fk = $arrayempresa[$aux]->id;
                    $model_avisa->rotina_fk = $arrayempresa[$aux]->rotina;
                    $model_avisa->nome_rotina = 'DEFIS';
                    $model_avisa->data_entrega = "$anoatual-$mesatual-31";
                    $model_avisa->status_chegada = 1;
                    $model_avisa->status_entrega = 0;
                    $model_avisa->data_chegada = "$anoatual-01-01";
                    $model_avisa->gera_auto = $data;
                    $model_avisa->save();
                    $aux++;
                } while ($aux < $cont2);
                return 1;
            } else {
                return 0;
            }
        }
    }
}

//essa função verifica se deverá ser gerado protocolo de entrega IRPF
function irpf(){
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('Y');
    if(Irpf::geraEntrega($data)){
        return 1;
    };
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
        return " $cont serviços PF pendentes!";
    }elseif($cont == 1){
        return " $cont serviço PF pendente!";
    }else{
        return 0;
    }
}

// retorna os serviços PF à prazo
function servicoPrazopf(){
    $vendas = Venda::find()->all();
    $aux = 0;
    foreach ($vendas as $venda){
        if($venda->form_pagamento == '1'){
            $aux++;
        }
    }
    if($aux>1) {
        return "$aux serviços PF aguardando pagamento!";
    }elseif($aux == 1) {
        return "$aux serviço PF aguardando pagamento!";
    }
}
// retorna os alerta de serviços PF à prazo
function alertaPrazopf(){
    $alertas = Alertaservico::find()->all();
    $aux = 0;
    foreach ($alertas as $alerta){
        if($alerta->status_pagamento == '0' && $alerta->status_servico == '2'){
            $aux++;
        }
    }
    if($aux>1) {
        return "$aux alerta PF aguardando pagamento!";
    }elseif($aux == 1) {
        return "$aux alerta PF aguardando pagamento!";
    }
}

// retorna os serviços PJ à prazo
function servicoPrazopj(){
    $vendas = Vendapj::find()->all();
    $aux = 0;
    foreach ($vendas as $venda){
        if($venda->form_pagamento == '1'){
            $aux++;
        }
    }
    if($aux>1) {
        return "$aux serviços PJ aguardando pagamento!";
    }elseif($aux == 1) {
        return "$aux serviço PJ aguardando pagamento!";
    }
}
// retorna os alerta de serviços PF à prazo
function alertaPrazopj(){
    $alertas = Alertaservicopj::find()->all();
    $aux = 0;
    foreach ($alertas as $alerta){
        if($alerta->status_pagamento == '0' && $alerta->status_servico == '2'){
            $aux++;
        }
    }
    if($aux>1) {
        return "$aux alerta PJ aguardando pagamento!";
    }elseif($aux == 1) {
        return "$aux alerta PJ aguardando pagamento!";
    }
}


// retorna o número de servicos/PJ pendentes
function servicopjPendente(){
    $cont = 0;
    $alertapj = Alertaservicopj::find()->all();
    foreach ($alertapj as $a){
        if(($a->status_servico == 0)  && (Yii::$app->user->identity->id == $a->usuario_fk)){
            $cont++;
        }
    }
    if($cont>1) {
        return " $cont serviços PJ pendentes!";
    }elseif($cont == 1){
        return " $cont serviço PJ pendente!";
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
        return " $cont serviços PF prontos para entrega!";
    }elseif($cont == 1){
        return " $cont serviço PF pronto para entrega!";
    }else{
        return 0;
    }
}
// retorna o número de servicos/pf prontos para entrega
function servicopjPronto(){
    $cont = 0;

    $alerta = Alertaservicopj::find()->all();

    foreach ($alerta as $a){
        if($a->status_servico == 1  && Yii::$app->user->identity->id == $a->usuario_fk){
            $cont++;
        }
    }
    if($cont>1) {
        return " $cont serviços PJ prontos para entrega!";
    }elseif($cont == 1){
        return " $cont serviço PJ pronto para entrega!";
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
//verifica se possui lembrete no dia
function lembrete(){
    date_default_timezone_set('America/Sao_Paulo');
    if(!Yii::$app->user->isGuest) {
        $lembretes = Lembrete::find()->all();
        $cont = 0;
        foreach ($lembretes as $lembrete) {
            if ($lembrete->usuario_fk == Yii::$app->user->identity->id && $lembrete->data == date('Y-m-d')){
                $cont++;
            }
        }
        if($cont){
            return $cont;
        }
    }
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
        return "$cont documentos pendentes";
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
                    <?php if(lembrete()) {
                        echo '<li class="messages-menu" >'.
                            '<a href = "/sigrecon/web/?r=lembrete" >'.
                            '<i class="fa fa-calendar"></i >'.'<span class="label label-warning">'.
                            lembrete()
                            .'</span>'.
                            '</a>'.
                            '</li>';
                    }
                    ?>

                    <li class="messages-menu" >
                        <a href = "/sigrecon/web/?r=mensagem" >

                            <?php if(recado()) {
                                echo '<i class="fa fa-envelope"></i >'.'<span class="label label-warning">';
                                echo recado();
                            }else{
                                echo'<i class="fa fa-envelope"></i>';
                            }
                            ?>
                            </span>
                        </a>
                    </li>

                    <?php
                    if (caixa()){
                        ?><li class="dropdown user user-menu">
                        <?php echo  Html::a(
                            '<span class="fa fa-usd"></span>  Abrir Caixa', ['abrircaixa/create'], ['data-method' => 'post', 'class' => 'btn-flat']
                        ); }?>
                        </li>

                    <?php if(novoUsuario() && Yii::$app->user->identity->tipo == 1){
                        echo
                            '<li class="dropdown notifications-menu">'.
                            '<a href="/sigrecon/web/?r=usuario">'.
                            '<i class="fa fa-user">'.
                            '</i>'.
                            '<span class="label label-warning">';
                        echo '!'.
                            '</a>'.
                            '</li>';
                    }?>


                    <!--                    Recebimentos pendentes-->
                    <li class="dropdown notifications-menu">
                        <!-- ISSO DEFINE O QUE FICA NO HEADEAR-->
                        <?php
                        if(servicoPrazopj() || alertaPrazopj() || servicoPrazopf() || alertaPrazopf()){
                            echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.
                                '<i class="fa fa-usd"></i>'.'<span class="label label-warning">'.
                                '+'.'</span>'.
                                '</a>';
                        }
                        ?>
                        <ul class="dropdown-menu">
                            <li class="header">
                                <?php
                                echo '<center>'."Recebimentos Pendentes".'</center>';
                                ?>
                            </li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li>
                                        <?php
                                        if(servicoPrazopj()) {
                                            echo '<a href="/sigrecon/web/?r=vendapj/prazopj"> <i class="fa fa-warning text-yellow"></i>'.servicoPrazopj().'</a>';
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        if(alertaPrazopj()) {
                                            echo '<a href="/sigrecon/web/?r=alertaservicopj/prazopj"> <i class="fa fa-warning text-yellow"></i>'.alertaPrazopj().'</a>';
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        if(servicoPrazopf()) {
                                            echo '<a href="/sigrecon/web/?r=venda/prazopf"> <i class="fa fa-warning text-yellow"></i>'.servicoPrazopf().'</a>';
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        if(alertaPrazopf()) {
                                            echo '<a href="/sigrecon/web/?r=alertaservico/prazopf"> <i class="fa fa-warning text-yellow"></i>'.alertaPrazopf().'</a>';
                                        }
                                        ?>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>


                    <li class="dropdown notifications-menu">
                        <!--                        //class warning para nova notificação-->
                        <?php
                        if(certificado() || procuracao() || servicoPronto() || servicoPendente() || servicopjPronto() || servicopjPendente()){
                            echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.'<i class="fa fa-bell"></i>'.'<span class="label label-warning">'.'!'.
                                '</span>'.
                                '</a>';
                        }
                        ?>
                        <ul class="dropdown-menu">
                            <li class="header">
                                <?php
                                echo '<center>'."Notificações".'</center>';
                                ?>
                            </li>
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
                                        if(servicopjPronto()) {
                                            echo '<a href="/sigrecon/web/?r=alertaservicopj/pronto"> <i class="fa fa-check-circle text-green"></i>'.servicopjPronto().'</a>';
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
                                        <?php
                                        if(servicopjPendente()) {
                                            echo '<a href="/sigrecon/web/?r=alertaservicopj/pendente"> <i class="fa fa-warning text-yellow"></i>'.servicopjPendente().'</a>';
                                        }
                                        ?>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown notifications-menu">
                        <!-- ISSO DEFINE O QUE FICA NO HEADEAR-->

                        <!--                        //class warning para nova notificação-->
                        <?php
                        simplesNacional();
                        if(rotinaAguardando()|| rotinaPronto() || rotinaPendente()){
                            echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.
                                '<i class="fa fa-flag"></i>'.'<span class="label label-warning">'.
                                '!'.'</span>'.
                                '</a>';
                        }
                        ?>

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

                <?php } ?>
                <!-- User Account: style can be found in dropdown.less -->

                <!--                Se o usuário não estiver logado apresenta o botão login-->
                <?php if (Yii::$app->user->isGuest){
                    ?>
                    <li class="dropdown user user-menu">
                        <?php echo  Html::a(
                            '<span class="fa fa-user-plus"></span>  Cadastre-se', ['/usuario/create'], ['data-method' => 'post', 'class' => 'btn-flat']
                        ); ?>
                    </li>
                    <li class="dropdown user user-menu">
                        <?php echo  Html::a(
                            '<span class="fa fa-sign-in"></span>  Login', ['/site/login'], ['data-method' => 'post', 'class' => 'btn-flat']
                        ); ?>
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
                                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
                                <p>
                                    <?= Yii::$app->user->identity->email;
                                    date_default_timezone_set('America/Sao_Paulo');
                                    $data = date('d/m/Y');
                                    ?>
                                    <small>Seja Bem Vindo!<br> <?php echo $data;?></small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <?php echo Html::a(
                                        '<span class="fa fa-user"></span>  Perfil',
                                        ['/usuario/view', 'id' => Yii::$app->user->identity->id],
                                        ['data-method' => 'post', 'class' => 'btn btn-warning btn-flat']
                                    ) ?>
                                </div>
                                <div class="pull-right">
                                    <?php echo Html::a(
                                        '<span class="fa fa-sign-out"></span>  Sair',
                                        ['/site/logout'],
                                        ['data-method' => 'post', 'class' => 'btn btn-danger btn-flat']
                                    ) ?>
                                </div>
                            </li>
                            <li>
                                <?php
                                if(Contabilidade::find()->one()) {
                                    echo '<div class="col-sm-12">';
                                    echo Html::a(
                                        '<span class="fa fa-gears"></span> Dados da Contabilidade',
                                        ['contabilidade/index'],
                                        ['data-method' => 'post', 'class' => 'btn btn-link']
                                    );
                                    '</div>';
                                }
                                ?>
                            </li>
                        </ul>
                    </li>
                <?php }?>
            </ul>
        </div>
    </nav>
</header>
