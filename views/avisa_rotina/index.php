<?php

use app\models\Empresa;
use app\models\Rotina;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\Avisa_rotinaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Controle de rotina';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
function empresa($model){
    $empresas = Empresa::find()->all();
    foreach ($empresas as $e){
        if($e->id == $model->empresa_fk){
            return "$e->razao_social";
        }
    }
}
function rotina($model){
    $rotinas = Rotina::find()->all();
    foreach ($rotinas as $r){
        if ($r->id == $model->rotina_fk) {
            return "$r->nome";
        }
    }
}
function chegada($model){
    $rotinas = Rotina::find()->all();
    $doc = 0;
    foreach ($rotinas as $r){
        if($r->id == $model->rotina_fk){
            $doc = $r->doc_busca;
        }
    }
    if(!$model->status_chegada){
        return "Aguardando: $doc";
    }else{
        return "$doc recebido(s)!";
    }
}
function entrega($model){
    if(!$model->status_entrega){
        return "Pendente!";
    }elseif ($model->status_entrega == 1){
        return "Pronto para entrega";
    }else{
        return "Entregue";
    }
}

?>

<div class="avisa-rotina-index box box-primary">
    <div class="box-header with-border">
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
                ['attribute' => 'empresa_fk',
                    'label' => 'Empresa',
                    'value' => function($model){
                        return empresa($model);
                    }],
                ['attribute' => 'rotina_fk',
                    'label' => 'Rotina',
                    'value'=> function($model){
                        return rotina($model);
                    }
                ],
                ['attribute' => 'status_chegada',
                    'value' => function($model){
                        return chegada($model);
                    }
                ],
                [
                    'attribute' =>'status_entrega',
                    'label' => 'Status do serviço',
                    'value' => function($model){
                        return entrega($model);
                    }
                ],
                ['attribute' => 'data_entrega',
                    'label' => 'Data Limite',
                    'format' => ['date', 'php: d/m/Y']
                ],
                // 'data_chegada',
                // 'data_pronto',
                ['attribute' => 'data_entregue',
                    'label' => 'Data da entrega',
                    'format' => ['date', 'php: d/m/Y']
                ],
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{view}{update}',
                ],
            ],
        ]); ?>
    </div>
</div>
