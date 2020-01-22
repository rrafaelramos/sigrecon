<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LembreteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lembretes';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$this->registerJs('
    $(document).on("click",".fc-day",function(){
        var date = $(this).attr("data-date");
        
        $.get("index.php?r=lembrete/create",{"date":date},function(data){
            $("#modal").modal("show")
            .find("#modalContent")
            .html(data);
        });
    });
    
    $(document).on("click",".fc-title",function(){
        var titulo = $(this).text();
        
        $.get("index.php?r=lembrete/view&id=".concat(1).concat("&titulo=").concat(titulo),function(data){
            $("#modalm").modal("show")
            .find("#modalmContent")
            .html(data);
        });
    });
');
?>




<div class="lembrete-index box box-primary">
    <div class="box-body table-responsive no-padding">
        <div class="col-sm-12">
            <?php
            Modal::begin([
                'header'=>'<h4>Novo Lembrete</h4>',
                'id'=>'modal',
                'size'=> 'modal-lg',
            ]);
            echo "<div id='modalContent'>  </div>";
            Modal::end();

            Modal::begin([
                'header'=>'<h4>Visualizar</h4>',
                'id'=>'modalm',
                'size'=> 'modal-lg',
            ]);
            echo "<div id='modalmContent'>  </div>";
            Modal::end();

            ?>


            <?= yii2fullcalendar\yii2fullcalendar::widget(array(
                'events' => $events,
                'clientOptions' => [
                    'locale'=>'pt-br',
                    'editable' => false,
                ]
            ))?>
        </div>
    </div>
</div>
