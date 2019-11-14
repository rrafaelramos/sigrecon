<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Bem Vindo</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Buscar..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'MENU', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    [
                        'label' => 'Cadastrar',
                        //'icon' => 'share',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Empresa', 'icon' => 'home', 'url' => ['/empresa'],],
                            ['label' => 'Cliente avulso', 'icon' => 'user', 'url' => ['/clienteavulso'],],
                            ['label' => 'Rotina', 'icon' => 'retweet', 'url' => ['/rotina'],],
                            ['label' => 'Serviço', 'icon' => 'usd', 'url' => ['/servico'],],
                            ['label' => 'Compra', 'icon' => 'pencil', 'url' => ['/compra'],],

                            //['label' => 'Empresa', 'icon' => 'institution', 'url' => ['/servico'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'label' => 'Consultar',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Empresas',
                                'icon' => 'home',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Dados Cadastrais', 'icon' => 'file', 'url' => ['/empresa'],],
                                    ['label' => 'Certificados/Procurações', 'icon' => 'calendar', 'url' => ['/datavencimento',]],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
