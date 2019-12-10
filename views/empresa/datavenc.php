<?php

use app\models\Empresa;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmpresaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Procurações e Certificados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresa-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Cadastrar Empresa', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
        <?= Html::a('Voltar', ['site/index'], ['class' => 'btn btn-warning btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'hover' => 'true',
            'resizableColumns'=>'true',
            'responsive' => 'true',
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                //'id',
//                ['attribute' => 'cnpj',
//                    'format' => 'html',
//                    'value' => function($model) {
//                        return preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '${1}.${2}.${3}/${4}-${5}', $model->cnpj);
//                    },
//                ],
                'razao_social',
                //'nome_fantasia',
                //'email:email',
//                ['attribute' => 'telefone',
//                    'format' => 'html',
//                    'value' => function($model) {
//                        return preg_replace('/^(\d{2})(\d{4})(\d{4})$/', '(${1}) ${2}-${3}', $model->telefone);
//                    },
//                ],
                // 'celular',
                // 'numero',
                // 'complemento',
                // 'rua',
                // 'bairro',
                // 'cidade',
                // 'cep',
                // 'uf',
                //'format' => ['date','php:d/m/Y'],
                // 'data_abertura',
                 [ 'attribute' => 'data_procuracao',
                     'value' => function($model){
                         date_default_timezone_set('America/Sao_Paulo');
                        if(strtotime($model->data_procuracao) > strtotime(date("Y-m-d"))){
                            //retorna a data do model, e transforma em um array
                            $dataprocuracao = explode('-',$model->data_procuracao);
                            $dia = $dataprocuracao[2];
                            $mes = $dataprocuracao[1];
                            $ano = $dataprocuracao[0];
                            return "$dia/$mes/$ano";
                        }elseif(strtotime($model->data_procuracao) == strtotime(date("Y-m-d"))){
                            return "Hoje!";
                        }else{
                            return 'Expirou!';
                        }
                     }
                 ],
                ['attribute' => 'data_certificado',
                    'value' => function($model){
                        if(strtotime($model->data_certificado) > strtotime(date("Y-m-d"))){
                            date_default_timezone_set('America/Sao_Paulo');
                            $datacertificado = explode('-',$model->data_certificado);
                            $diac = $datacertificado[2];
                            $mesc = $datacertificado[1];
                            $anoc = $datacertificado[0];
                            return "$diac/$mesc/$anoc";
                        }elseif(strtotime($model->data_certificado) == strtotime(date("Y-m-d"))){
                            return 'Hoje!';
                        }else{
                            return 'Expirou';
                        }
                    }

                ],
                // 'rotina',
                'responsavel',
                // 'cpf_socio',
                // 'datanascimento_socio',
                // 'rg',
                // 'titulo',
                // 'nome_mae_socio',
                ['attribute' => 'telefone_socio',
                    'format' => 'html',
                    'value' => function($model) {
                        return preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->celular);
                    },
                ],
                // 'usuario_fk',

                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{view}{update}',
                ],

            ],
        ]); ?>
    </div>
</div>
