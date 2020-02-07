<?php

use yii\bootstrap\Alert;

$this->title = 'Relatorio de Vendas';
$this->params['breadcrumbs'][] = $this->title;
date_default_timezone_set('America/Sao_Paulo');

?>

<div class="venda-form col-sm-12">
    <div class="venda-form box box-primary">
        <div class="box-body table-responsive col-sm-11">
            <div class="col-sm-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Relatório de Vendas</h3>
                    </div>
                    <div class="panel-body">
                        <form action="/sigrecon/web/index.php?r=relatorio_caixa/relatorio" method="post">
                            <div class="col-sm-6">
                                <label for="inicio">Inicio:</label>
                                <input type="date" id="inicio" name="data_inicio" required/>
                            </div>
                            <div class="col-sm-6">
                                <label for="fim">Fim:</label>
                                <input type="date" id="fim" name="data_fim" required/>
                            </div>
                            <div class="col-sm-12">
                                <button class="btn btn-primary btn-flat pull-right" type="submit">Gerar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="col-sm-6 col-sm-offset-3">
        <?php
        echo Alert::widget([
            'options' => [
                'class' => 'alert-warning',
            ],
            'body' => 'Data Inicial não pode Ser maior que a Data Final!',
        ]);
        ?>
    </div>
</div>