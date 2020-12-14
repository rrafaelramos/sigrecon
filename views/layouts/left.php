<aside class="main-sidebar">
    <section class="sidebar">

        <!-- Sidebar user panel -->
        <?php if(!Yii::$app->user->isGuest){ ?>
            <div class="user-panel">
                <div class="pull-left image">
                    <?php  echo yii\helpers\Html::img(Yii::$app->request->baseUrl.'/img/user1.png', ['class' => 'img-circle', 'alt' => 'USUÁRIO']); ?>
                </div>
                <div class="pull-left info">
                    <p>
                        <?php
                        $aux = explode(" ", Yii::$app->user->identity->nome);
                        $nome = $aux[0];
                        echo $nome;
                        ?>
                    </p>

                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
        <?php } ?>

        <?= dmstr\widgets\Menu::widget([
            'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
            'items' => [
                ['label' => 'MENU', 'options' => ['class' => 'header']],
//                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
//                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                ['label' => 'Compromissos', 'icon' => 'calendar', 'url' => ['/lembrete'],],
                [
                    'label' => 'Cadastrar',
                    //'icon' => 'share',
                    'icon' => 'plus',
                    'url' => '#',
                    'items' => [
                        ['label' => 'Empresa', 'icon' => 'home', 'url' => ['/empresa/create'],],
                        ['label' => 'Associação', 'icon' => 'university', 'url' => ['/associacao/create'],],
                        ['label' => 'Cliente PF', 'icon' => 'user-plus', 'url' => ['/clienteavulso/create'],],
//                            ['label' => 'Rotina', 'icon' => 'retweet', 'url' => ['/rotina'],],
                        ['label' => 'Serviço', 'icon' => 'usd', 'url' => ['/servico/create'],],
                        //['label' => 'Empresa', 'icon' => 'institution', 'url' => ['/servico'],],
//                            [
//                                'label' => 'Level One',
//                                'icon' => 'circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
                    ],
                ],
                [
                    'label' => 'Serviço PF',
                    'icon' => 'usd',
                    'url' => '#',
                    'items' => [
                        ['label' => 'Serviço Avulso','icon' => 'circle-o', 'url' => ['/venda/create']],
                        ['label' => 'Alerta de Serviço','icon' => 'circle-o', 'url' => ['/alertaservico/create']],
                    ],
                ],
                [
                    'label' => 'Serviço PJ',
                    'icon' => 'usd',
                    'url' => '#',
                    'items' => [
                        ['label' => 'Serviço Avulso','icon' => 'circle-o', 'url' => ['/vendapj/create']],
                        ['label' => 'Alerta de Serviço','icon' => 'circle-o', 'url' => ['/alertaservicopj/create']],
                    ],
                ],

                [
                    'label' => 'Consultar',
                    'icon' => 'share-square',
                    'url' => '#',
                    'items' => [
                        [
                            'label' => 'Empresas',
                            'icon' => 'home',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Dados Cadastrais', 'icon' => 'file', 'url' => ['/empresa']],
                                ['label' => 'Docs. de Rotina', 'icon' => 'folder-open', 'url' => ['/avisa_rotina',]],
                                ['label' => 'Certificados/Procurações', 'icon' => 'calendar', 'url' => ['/empresa/datavenc',]],
                            ],
                        ],
                        [
                            'label' => 'Associações',
                            'icon' => 'university',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Dados Cadastrais', 'icon' => 'file', 'url' => ['/associacao']],
                                ['label' => 'Certificados/Procurações', 'icon' => 'calendar', 'url' => ['/associacao/datavenc',]],
                                ['label' => 'RAIS', 'icon' => 'pencil-square-o', 'url' => ['/rais',]],
                                ['label' => 'DCTF', 'icon' => 'pencil-square-o', 'url' => ['/dctf',]],
                                ['label' => 'ECF', 'icon' => 'pencil-square-o', 'url' => ['/ecf',]],
                            ],
                        ],
                        [
                            'label' => 'Caixa',
                            'icon' => 'tasks',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Serviços PF', 'icon' => 'usd', 'url' => ['/venda'],],
                                ['label' => 'Serviços PJ', 'icon' => 'usd', 'url' => ['/vendapj'],],
                                ['label' => 'Despesas', 'icon' => 'usd', 'url' => ['/compra'],],
                                ['label' => 'Fechamentos', 'icon' => 'pencil-square-o', 'url' => ['/fcaixa']],
                                ['label' => 'Honorários recebidos', 'icon' => '', 'url' => ['/honorario']],
                            ],
                        ],
                        ['label' => 'Cliente PF', 'icon' => 'user', 'url' => ['/clienteavulso'],],
                        ['label' => 'Serviços', 'icon' => '', 'url' => ['/servico'],],
                    ],
                ],
                [
                    'label' => 'Caixa',
                    'icon' => 'share-square',
                    'url' => '#',
                    'items' => [
                        ['label' => 'Registrar Compra', 'icon' => 'pencil', 'url' => ['/compra/create'],],
                        ['label' => 'Lançar Despesa', 'icon' => 'pencil', 'url' => ['compra/saida'],],
                        ['label' => 'Lançar Honorário', 'icon' => 'usd', 'url' => ['/honorario/create'],],
                        ['label' => 'Fechar Caixa', 'icon' => 'lock', 'url' => ['/fcaixa/create'],],
                        ['label' => 'Consultar Saldo', 'icon' => 'usd', 'url' => ['fcaixa/consulta']]
                    ],
                ],
                [
                    'label' => 'Relatórios',
                    'icon' => 'file',
                    'url' => '#',
                    'items' => [
                        ['label' => 'Receitas', 'icon' => 'usd', 'url' => ['/relatorio_caixa'],],
                        ['label' => 'Produtividade', 'icon' => 'usd', 'url' => ['/relatorio-venda'],],
                    ],
                ],
            ],
        ]) ?>
    </section>
</aside>
