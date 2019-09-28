<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmpresaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Empresas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresa-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Cadastrar Empresa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'cnpj',
            'razao_social',
            'nome_fantasia',
            'email:email',
            'telefone',
            //'celular',
            //'numero',
            //'complemento',
            //'rua',
            //'bairro',
            //'cidade',
            //'cep',
            //'uf',
            //'data_abertura',
            //'data_procuracao',
            //'data_certificado',
            //'rotina',
            'responsavel',
            //'cpf_socio',
            //'datanascimento_socio',
            //'rg',
            //'titulo',
            //'nome_mae_socio',
            //'telefone_socio',
            //'usuario_fk',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
