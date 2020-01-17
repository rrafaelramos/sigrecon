<?php

use app\models\Rotina;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use unclead\multipleinput\MultipleInput;

/* @var $this yii\web\View */
/* @var $model app\models\Rotina */
/* @var $rotina app\models\Rotina */

$rotina = new Rotina();
?>
<div class="clienteavulso-view box box-primary">
    <div class="box-header with-border">
        <div class="pull-right">
            <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-warning btn-flat']) ?>
            <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
            <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-flat',
                'data' => [
                    'confirm' => 'Deseja realmente apagar?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel-group collapse in">
            <div class="panel panel-default">
                <div class="panel-heading with-border col-xs-12">
                    <div class="col-xs-10">
                        <h2 class="panel-title">Dados da Rotina</h2>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'nome',
                            ['attribute' => 'repeticao',
                                'value' => function($model){
                                    if($model->repeticao == '1'){
                                        return 'Todo Mês';
                                    }elseif($model->repeticao == '2'){
                                        return 'À cada 3 Meses';
                                    }elseif ($model->repeticao == '3'){
                                        return 'À Cada 6 Meses';
                                    }else{
                                        return 'Uma Vez ao Ano';
                                    }
                                }
                            ],
                            'doc_busca',
                            'doc_entrega',
                            ['attribute' => 'data_entrega',
                                'value' => function($model){
                                    $aux = explode('-',$model->data_entrega);
                                    $dia = $aux[2];
                                    $mes = $aux[1];
                                    switch ($mes){
                                        case '01':
                                            $mes = 'Janeiro';
                                            break;
                                        case '02':
                                            $mes = 'Fevereiro';
                                            break;
                                        case '03':
                                            $mes = 'Março';
                                            break;
                                        case '04':
                                            $mes = 'Abril';
                                            break;
                                        case '05':
                                            $mes = 'Maio';
                                            break;
                                        case '06':
                                            $mes = 'Junho';
                                            break;
                                        case '07':
                                            $mes = 'Julho';
                                            break;
                                        case '08':
                                            $mes = 'Agosto';
                                            break;
                                        case '09':
                                            $mes = 'Setembro';
                                            break;
                                        case '10':
                                            $mes = 'Outubro';
                                            break;
                                        case '11':
                                            $mes = 'Novembro';
                                            break;
                                        case '12':
                                            $mes = 'Dezembro';
                                            break;
                                    }
                                    if($model->repeticao == '1') {
                                        return "Todo dia: $dia de cada mês a vencer";
                                    }elseif($model->repeticao == '2'){
                                        return "Todo dia $dia à cada 3 Meses";
                                    }elseif($model->repeticao == '3'){
                                        return "Todo dia $dia à cada 6 Meses";
                                    }else{
                                        return "Todo dia $dia de $mes";
                                    }
                                }
                            ],
//                        ['attribute' => 'data_entrega',
//                            'format' => ['date', 'php:d/m/Y'],
//                        ],
                            ['attribute' => 'data_aviso',
                                'value' => function($model){
                                    $data = explode('-',$model->data_aviso);
                                    $dia = $data[2];
                                    $mes = $data[1];
                                    switch ($mes){
                                        case '01':
                                            $mes = 'Janeiro';
                                            break;
                                        case '02':
                                            $mes = 'Fevereiro';
                                            break;
                                        case '03':
                                            $mes = 'Março';
                                            break;
                                        case '04':
                                            $mes = 'Abril';
                                            break;
                                        case '05':
                                            $mes = 'Maio';
                                            break;
                                        case '06':
                                            $mes = 'Junho';
                                            break;
                                        case '07':
                                            $mes = 'Julho';
                                            break;
                                        case '08':
                                            $mes = 'Agosto';
                                            break;
                                        case '09':
                                            $mes = 'Setembro';
                                            break;
                                        case '10':
                                            $mes = 'Outubro';
                                            break;
                                        case '11':
                                            $mes = 'Novembro';
                                            break;
                                        case '12':
                                            $mes = 'Dezembro';
                                            break;
                                    }
                                    if($model->repeticao == '1') {
                                        return "Todo dia: $dia de cada mês a vencer";
                                    }elseif($model->repeticao == '2'){
                                        return "Todo dia $dia à cada 3 Meses";
                                    }elseif($model->repeticao == '3'){
                                        return "Todo dia $dia à cada 6 Meses";
                                    }else{
                                        return "Todo dia $dia de $mes";
                                    }
                                }
                                //'format' => ['date', 'php:d/m/Y'],
                            ],
                            'informacao',
                            'msg_aviso',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

$form = ActiveForm::begin();

    echo $form->field($rotina, 'empresa_fk')->widget(MultipleInput::className(), [
        'max'               => 6,
        'min'               => 1, // should be at least 2 rows
        'allowEmptyList'    => false,
        'enableGuessTitle'  => true,
        'addButtonPosition' => MultipleInput::POS_HEADER, // show add button in the header
    ])
    ->label(false);
?>

<?= Html::submitButton('Salvar', ['class' => 'btn btn-success btn-flat']) ?>
<?php ActiveForm::end();?>
