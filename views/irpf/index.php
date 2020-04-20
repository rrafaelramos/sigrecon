<?php

use app\models\Clienteavulso;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IrpfSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

function cliente($model){
    $clientes = Clienteavulso::find()->all();
    foreach($clientes as $cliente){
        if($cliente->id == $model){
            return $cliente->nome;
        }
    }
}

$this->title = 'Lista IRPF';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rotina-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Início', ['site/index'], ['class' => 'btn btn-primary btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'hover' => 'true',
            'resizableColumns'=>'true',
            'responsive' => 'true',
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [

                ['class' => 'yii\grid\SerialColumn'],
//                'id',
                ['attribute' => 'cliente_fk',
                    'label' => 'Cliente',
                    'value' => function($model){
                        return cliente($model->cliente_fk);
                    }
                ],
                ['attribute' => 'telefone',
                    'format' => 'html',
                    'value' => function($model) {
                        return preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->telefone);
                    },
                ],
                ['attribute' => 'data_entrega',
                    'label' => 'Data de Entrega',
                    'format' => ['date','php:d/m/Y']
                ],
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{view}',
                ],
            ],
        ]); ?>
    </div>
</div>
