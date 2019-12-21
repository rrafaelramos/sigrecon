<?php

use app\models\Empresa;
use app\models\Servico;
use app\models\Usuario;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Alertaservico;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AlertaservicoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Alerta: Serviço Pendente';
$this->params['breadcrumbs'][] = $this->title;

function empresa($model){
    $empresa = Empresa::find()->all();

    foreach ($empresa as $e){
        if($e->id == $model->empresa_fk){
            return $e->razao_social;
        }
    }
}

function usuario($model){
    $usuario = Usuario::find()->all();
    foreach ($usuario as $u){
        if($u->id == $model->usuario_fk){
            return $u->nome;
        }
    }
}

function servico($model){
    $servico = Servico::find()->all();
    foreach ($servico as $s){
        if($s->id == $model->servico_fk){
            return $s->descricao;
        }
    }
}

function pagamento($model){
    if($model->status_pagamento == 0){
        return 'Aguardando Pagamento';
    }elseif ($model->status_pagamento == 1){
        return 'Pago';
    }else{
        return 'Pago no honorário';
    }
}

function status($model){
    if($model->status_servico == 0){
        return 'Pendente';
    }elseif ($model->status_servico == 1){
        return 'Pronto para entrega';
    }else{
        return 'Entregue';
    }
}
?>
<div class="servico-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Voltar', ['site/index'], ['class' => 'btn btn-warning btn-flat'])?>
        <?= Html::a('Cadastrar alerta', ['create'], ['class' => 'btn btn-success btn-flat'])?>
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
//                [
//                    'attribute' => 'id',
//                    'label' => 'N° do Alerta',
//                ],
                [
                    'attribute' => 'empresa_fk',
                    'label' => 'Empresa',
                    'value' => function($model){
                        return empresa($model);
                    }
                ],
                ['attribute' => 'data_entrega',
                    'label' => 'Data de Entrega',
                    'format' =>['date','php:d/m/Y']
                ],
                ['attribute' => 'servico_fk',
                    'label' => 'Serviço',
                    'value' => function($model){
                        return servico($model);
                    }],
                //'quantidade',
                // 'info:ntext',
                ['attribute' => 'status_pagamento',
                    'label' => 'Situação do Pagamento',
                    'value' => function($model){
                        return pagamento($model);
                    }],
                ['attribute' => 'status_servico',
                    'label' => 'Status',
                    'value' => function ($model){
                        return status($model);
                    }],
                // 'usuario_fk',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
