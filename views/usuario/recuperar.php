<?php
use app\models\Usuario;

$this->title = 'SIGRECon';
$model = new Usuario();
$model->load(Yii::$app->request->post());

?>

<div class="panel-body">
    <div class="col-sm-6">
        <div class="row">
            <div class="card-content">
                <h2>Verifique o seu e-mail!</h2>
                <p>Para escolher uma nova senha clique no link que enviamos para o seu e-mail: <font color="blue"><?php echo $model->email; ?></font>
                </p>
                <p class="spacer">Caso não consiga visualizar o e-mail, verifique outras pastas que ele possa estar, como pasta de lixo eletrônico, spam ou outras.
                </p>
                <p class="smaller-text margin">Não recebeu o e-mail? Entre em contato com o Gerente </p>
            </div>
        </div>
    </div>
</div>