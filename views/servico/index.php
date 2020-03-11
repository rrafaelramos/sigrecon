<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\icons\Icon;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ServicoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Serviços';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php

function formatar($model){
    $formatter = Yii::$app->formatter;

    $formatado = $formatter->asCurrency($model);

    //$remove = array("pt-br");

    $dinheiro = str_replace("pt-br", "", $formatado);
    return $dinheiro;
}
?>


<div class="servico-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Novo +', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
        <?= Html::a('Voltar', ['site/index'], ['class' => 'btn btn-primary btn-flat pull-right'])?>
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
                //['class' => 'yii\grid\SerialColumn'],
               // 'id',
                'descricao',
                ['attribute' => 'valor',
                    'value' => function($model) {
                         return "R$".formatar($model->valor);
                        }
                    ],
//                ['attribute' => 'valor_minimo',
//                    'value' => function($model){
//                        return "R$".formatar($model->valor_minimo);
//                    }
//                    ],
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{view}{update}',
                ],
            ],
        ]); ?>
    </div>
</div>
