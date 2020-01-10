<?php

use app\models\Usuario;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MensagemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mensagems';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
function emissor($model){
    $usuarios = Usuario::find()->all();
    foreach ($usuarios as $u){
        if ($u->id == $model->emissor){
            return $u->nome;
        }
    }
}

?>
<div class="mensagem-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Novo Recado', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
        <?= Html::a('Voltar', ['site/index'], ['class' => 'btn btn-warning btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= \kartik\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'hover' => 'true',
            'resizableColumns'=>'true',
            'responsive' => 'true',
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                ['attribute' => 'emissor',
                    'value' => function($model){
                        return emissor($model);
                    }
                ],
                //'receptor',
                ['attribute' => 'data_envio',
                    'format' => ['date', 'php: d/m/Y']
                ],
                'titulo',
                // 'conteudo:ntext',
                // 'empresa_fk',
                // 'servico_fk',
                // 'lido',

                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{view}{delete}',
                ],
            ],
        ]); ?>
    </div>
</div>
