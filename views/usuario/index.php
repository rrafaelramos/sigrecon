<?php

use yii\bootstrap\Alert;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
?>

<?php
function autoriza($model){
    if($model->tipo == 1){
        return 'Gerente';
    }elseif ($model->tipo == 0){
        return "+ Solicitado +";
    }elseif($model->tipo == 2){
        return "Colaborador";
    }else{
        return "Solicitação Recusada!";
    }
}
?>

<?php if(Yii::$app->user->identity->tipo == 1){
    $this->params['breadcrumbs'][] = $this->title;
    ?>

    <div class="usuario-index box box-primary">
        <div class="box-header with-border">
            <?= Html::a('Create Usuario', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
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
                    'nome',
                    'username',
                    //'password',
                    'email:email',
                    ['attribute' => 'tipo',
                        'label' => 'Autorização',
                        'value' => function($model){
                            return autoriza($model);
                        }
                    ],
                    // 'authKey',

                    [
                        'class' => '\kartik\grid\ActionColumn',
                        'template' => '{view}{update}',
                    ],
                ],
            ]); ?>
        </div>
    </div>
<?php }else{
    echo Alert::widget([
        'options' => [
            'class' => 'alert-danger',
        ],
        'body' => 'Usuário Não Autorizado!!',
    ]);
    echo Html::a('Início',['/site/index'],['class' => 'btn btn-warning btn-flat pull-center']);
}?>