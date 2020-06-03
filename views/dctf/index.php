<?php

use app\models\Associacao;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DctfSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'DCTF';
$this->params['breadcrumbs'][] = $this->title;

function buscacnpj($associacao_id){
    $asso = Associacao::find()->all();
    foreach ($asso as $assoc){
        if ($assoc->id == $associacao_id){
            return $assoc->cnpj;
        }
    }
}

?>
<div class="empresa-index box box-primary">
    <?php Pjax::begin(['enablePushState' => false]); ?>
    <div class="box-header with-border">
        <?= Html::a('Voltar', ['site/index'], ['class' => 'btn btn-primary btn-flat pull-right']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= \kartik\grid\GridView::widget([
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'hover' => 'true',
            'resizableColumns'=>'true',
            'responsive' => 'true',
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                //'associacao_id',
                'associacao_nome',
                ['attribute' => 'cnpj',
                    'label' => 'CNPJ',
                    'format' => 'html',
                    'value' => function($model) {
                        return preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '${1}.${2}.${3}/${4}-${5}', buscacnpj($model->associacao_id));
                    },
                ],
                ['attribute' => 'data_limite',
                    'format' => ['date', 'php:d/m/Y']
                ],
                'presidente',
                ['attribute' => 'fone_presidente',
                    'format' => 'html',
                    'value' => function($model) {
                        return preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '(${1}) ${2} ${3}-${4}', $model->fone_presidente);
                    },
                ],
                'feito',
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{view}{update}{delete}',
                ],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
