<?php

namespace app\models;

use Yii;
use PhpOffice\PhpWord\PhpWord;

/**
 * This is the model class for table "abrircaixa".
 *
 * @property int $id
 * @property string|null $data
 * @property float|null $valor
 */
class RelatorioVendaFuncionario extends \yii\base\Model
{
    public $inicio, $fim, $colaborador;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inicio','fim'], 'safe'],
            [['colaborador'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inicio' => 'Início',
            'fim' => 'Fim',
            'colaborador' => 'Colaborador',
        ];
    }


    function formatar($model){

        if(!$model){
            return "R$ 0,00";
        }
        $formatter = Yii::$app->formatter;
        $formatado = $formatter->asCurrency($model);
        $dinheiro = str_replace("pt-br", "", $formatado);
        return "R$$dinheiro";
    }

    public function geraRelatorio($inicio, $fim, $colaborador)
    {
        $tp = new \PhpOffice\PhpWord\TemplateProcessor(Yii::getAlias('@app') . '/documentos/relatorio_venda_funcionario/relatorio_venda_funcionario.docx');
        $vendas = Venda::find()->all();
        $data_venda = 0;
        $i = 0;
        $cont = 0;

        foreach ($vendas as $venda) {
            if ($venda->usuario_fk == $colaborador) {
                $data_aux = explode(" ", $venda->data);
                $data_venda = $data_aux[0];
                if (strtotime($inicio) <= strtotime($data_venda) && strtotime($data_venda) <= strtotime($fim)) {
                    $cont++;
                }
            }
        }

        $tp->cloneRow('cliente', $cont);

        ini_set('max_execution_time', 300); //300 seconds = 5 minute
        date_default_timezone_set('America/Sao_Paulo');

        $servicos = Servico::find()->all();

        $contabilidade = Contabilidade::find()->one();

        $tp->setValue('contabilidade', "$contabilidade->nome");
        $tp->setValue('rua', "$contabilidade->rua");
        $tp->setValue('n', "$contabilidade->numero");
        $tp->setValue('bairro', "$contabilidade->bairro");
        $tp->setValue('cidade', "$contabilidade->cidade");
        $tp->setValue('data',date('d/m/Y'));

        $nome = 0;
        $tipo = 0;

        $usuarios = Usuario::find()->all();
        foreach ($usuarios as $usuario){
            if($usuario->id == $colaborador){
                $nome = $usuario->nome;
            }
            if($usuario->tipo == '1'){
                $tipo = 'Gerente';
            }else{
                $tipo = 'Colaborador';
            }
        }
        $tp->setValue('colaborador', "$nome");
        $tp->setValue('tipo', "$tipo");

        $clientes = Clienteavulso::find()->all();
        $cliente_nome = "Não cadastrado";

        foreach ($vendas as $venda) {
            if ($venda->usuario_fk == $colaborador) {
                $data_aux = explode(" ", $venda->data);
                $data_venda = $data_aux[0];
                if (strtotime($inicio) <= strtotime($data_venda) && strtotime($data_venda) <= strtotime($fim)) {
                    if(!$venda->cliente_fk){
                        $tp->setValue('cliente#' . ($i + 1), "Não cadastrado!");
                    }else {
                        foreach ($clientes as $cliente) {
                            if($cliente->id == $venda->cliente_fk){
                                $tp->setValue('cliente#' . ($i + 1), $cliente->nome);
                            }
                        }
                    }
                    foreach ($servicos as $servico){
                        if($servico->id == $venda->servico_fk){
                            $tp->setValue('servico#' . ($i + 1), $servico->descricao);
                        }
                    }
                    $tp->setValue('quantidade#' . ($i + 1), $venda->quantidade);
                    $tp->setValue('total#' . ($i + 1), RelatorioVendaFuncionario::formatar($venda->tot_sem_desconto));
                    $tp->setValue('desconto#' . ($i + 1), RelatorioVendaFuncionario::formatar($venda->desconto));
                    $tp->setValue('recebido#' . ($i + 1), RelatorioVendaFuncionario::formatar($venda->total));
                    $i++;
                }
            }
        }

        $tp->saveAs(Yii::getAlias('@app') . '/documentos/relatorio_venda_funcionario/relatorio_venda_funcionario_temp.docx');
    }
}
