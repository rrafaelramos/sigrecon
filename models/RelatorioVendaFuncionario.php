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
            [['inicio', 'fim'], 'safe'],
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

    function formatar($model)
    {
        $formatter = Yii::$app->formatter;
        if ($model) {
            $formatado = $formatter->asDecimal($model, 2);
            $valor = "R$ " . $formatado;
            return $valor;
        } else
            return 'R$ 0,00';
    }

    function formatData($data)
    {
        $data_inicio = explode(" ", $data);
        $retorno = $data_inicio[0];

        $br = explode("-",$retorno);

        $data_br = "$br[2]/$br[1]/$br[0]";

        return $data_br;
    }

    public function geraRelatorio($inicio, $fim, $colaborador)
    {
        $tp = new \PhpOffice\PhpWord\TemplateProcessor(Yii::getAlias('@app') . '/documentos/relatorio_venda_funcionario/relatorio_venda_funcionario.docx');
        $vendas = Venda::find()->all();
        $vendaspj = Vendapj::find()->all();
        $data_venda = 0;
        $data_vendapj = 0;
        $i = 0;
        $cont = 0;
        $contpj = 0;

        foreach ($vendas as $venda) {
            if ($venda->usuario_fk == $colaborador) {
                $data_aux = explode(" ", $venda->data);
                $data_venda = $data_aux[0];
                if (strtotime($inicio) <= strtotime($data_venda) && strtotime($data_venda) <= strtotime($fim)) {
                    $cont++;
                }
            }
        }

        //buscas as vendas para pj
        foreach ($vendaspj as $venda) {
            if ($venda->usuario_fk == $colaborador) {
                $data_aux = explode(" ", $venda->data);
                $data_vendapj = $data_aux[0];
                if (strtotime($inicio) <= strtotime($data_vendapj) && strtotime($data_vendapj) <= strtotime($fim)) {
                    $contpj++;
                }
            }
        }

        ini_set('max_execution_time', 300); //300 seconds = 5 minute
        date_default_timezone_set('America/Sao_Paulo');

        $servicos = Servico::find()->all();
        $contabilidade = Contabilidade::find()->one();

        $tp->setValue('contabilidade', "$contabilidade->nome");
        $tp->setValue('rua', "$contabilidade->rua");
        $tp->setValue('n', "$contabilidade->numero");
        $tp->setValue('bairro', "$contabilidade->bairro");
        $tp->setValue('cidade', "$contabilidade->cidade");
        $tp->setValue('data', date('d/m/Y'));

        $nome = 0;
        $tipo = 0;

        $tp->cloneRow('cliente', $cont);

        $usuarios = Usuario::find()->all();
        foreach ($usuarios as $usuario) {
            if ($usuario->id == $colaborador) {
                $nome = $usuario->nome;
            }
            if ($usuario->tipo == '1') {
                $tipo = 'Gerente';
            } else {
                $tipo = 'Colaborador';
            }
        }
        $tp->setValue('colaborador', "$nome");
        $tp->setValue('tipo', "$tipo");

        $clientes = Clienteavulso::find()->all();
        $cliente_nome = "Não cadastrado";

        $total =0;

        foreach ($vendas as $venda) {
            if ($venda->usuario_fk == $colaborador) {
                $data_aux = explode(" ", $venda->data);
                $data_venda = $data_aux[0];
                if (strtotime($inicio) <= strtotime($data_venda) && strtotime($data_venda) <= strtotime($fim)) {
                    $total+=$venda->total;
                    if (!$venda->cliente_fk) {
                        $tp->setValue('cliente#' . ($i + 1), "Não cadastrado!");
                    } else {
                        foreach ($clientes as $cliente) {
                            if ($cliente->id == $venda->cliente_fk) {
                                $tp->setValue('cliente#' . ($i + 1), $cliente->nome);
                            }
                        }
                    }
                    foreach ($servicos as $servico) {
                        if ($servico->id == $venda->servico_fk) {
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

        $empresas = Empresa::find()->all();
        $j = 0;
        $tp->cloneRow('empresa', $contpj);

        foreach ($vendaspj as $vendapj) {
            if ($vendapj->usuario_fk == $colaborador) {
                $data_aux = explode(" ", $vendapj->data);
                $data_vendapj = $data_aux[0];
                if (strtotime($inicio) <= strtotime($data_vendapj) && strtotime($data_vendapj) <= strtotime($fim)) {
                    $total+=$vendapj->total;
                    if (!$vendapj->empresa_fk) {
                        $tp->setValue('empresa#' . ($j + 1), "Não cadastrado!");
                    } else {
                        foreach ($empresas as $empresa) {
                            if ($empresa->id == $vendapj->empresa_fk) {
                                $tp->setValue('empresa#' . ($j + 1), $empresa->razao_social);
                            }
                        }
                    }
                    foreach ($servicos as $servico) {
                        if ($servico->id == $vendapj->servico_fk) {
                            $tp->setValue('servicoj#' . ($j + 1), $servico->descricao);
                        }
                    }
                    $tp->setValue('quantidadej#' . ($j + 1), $vendapj->quantidade);
                    $tp->setValue('totalj#' . ($j + 1), RelatorioVendaFuncionario::formatar($vendapj->tot_sem_desconto));
                    $tp->setValue('descontoj#' . ($j + 1), RelatorioVendaFuncionario::formatar($vendapj->desconto));
                    $tp->setValue('recebidoj#' . ($j + 1), RelatorioVendaFuncionario::formatar($vendapj->total));
                    $j++;
                }
            }
        }

        $tp->setValue('retorno', RelatorioVendaFuncionario::formatar($total));
        $tp->setValue('inicio', RelatorioVendaFuncionario::formatData($inicio));
        $tp->setValue('fim', RelatorioVendaFuncionario::formatData($fim));



        $tp->saveAs(Yii::getAlias('@app') . '/documentos/relatorio_venda_funcionario/relatorio_venda_funcionario_temp.docx');
    }



    public function geraGeral($inicio, $fim)
    {
        $tp = new \PhpOffice\PhpWord\TemplateProcessor(Yii::getAlias('@app') . '/documentos/relatorio_venda/relatorio_venda.docx');
        ini_set('max_execution_time', 300); //300 seconds = 5 minute
        date_default_timezone_set('America/Sao_Paulo');

        $contabilidade = Contabilidade::find()->one();
        $tp->setValue('contabilidade', "$contabilidade->nome");
        $tp->setValue('rua', "$contabilidade->rua");
        $tp->setValue('n', "$contabilidade->numero");
        $tp->setValue('bairro', "$contabilidade->bairro");
        $tp->setValue('cidade', "$contabilidade->cidade");
        $tp->setValue('data', date('d/m/Y'));

        $vendas = Venda::find()->all();
        $cont = 0;

        foreach ($vendas as $venda){
            $data_aux = explode(" ", $venda->data);
            $data_venda = $data_aux[0];
            if(strtotime($inicio) <= strtotime($data_venda) && strtotime($data_venda) <= strtotime($fim)) {
                $cont++;
            }
        }

        $tp->cloneRow('colaborador', $cont);

        $servicos = Servico::find()->all();
        $usuarios = Usuario::find()->all();
        $i = 0;

        foreach ($vendas as $venda) {
            $data_aux = explode(" ", $venda->data);
            $data_venda = $data_aux[0];
            if (strtotime($inicio) <= strtotime($data_venda) && strtotime($data_venda) <= strtotime($fim)) {
                foreach ($usuarios as $usuario){
                    if($usuario->id == $venda->usuario_fk){
                        $tp->setValue('colaborador#' . ($i + 1), $usuario->nome);
                    }
                }

                foreach ($servicos as $servico) {
                    if ($servico->id == $venda->servico_fk) {
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

        // vendas para PJ
        $vendaspj = Vendapj::find()->all();
        $contj = 0;

        foreach ($vendaspj as $venda){
            $data_aux = explode(" ", $venda->data);
            $data_venda = $data_aux[0];
            if(strtotime($inicio) <= strtotime($data_venda) && strtotime($data_venda) <= strtotime($fim)) {
                $contj++;
            }
        }

        $tp->cloneRow('colaboradorj', $contj);

        $servicos = Servico::find()->all();
        $usuarios = Usuario::find()->all();
        $i = 0;

        foreach ($vendaspj as $venda) {
            $data_aux = explode(" ", $venda->data);
            $data_venda = $data_aux[0];
            if (strtotime($inicio) <= strtotime($data_venda) && strtotime($data_venda) <= strtotime($fim)) {
                foreach ($usuarios as $usuario){
                    if($usuario->id == $venda->usuario_fk){
                        $tp->setValue('colaboradorj#' . ($i + 1), $usuario->nome);
                    }
                }

                foreach ($servicos as $servico) {
                    if ($servico->id == $venda->servico_fk) {
                        $tp->setValue('servicoj#' . ($i + 1), $servico->descricao);
                    }
                }

                $tp->setValue('quantidadej#' . ($i + 1), $venda->quantidade);
                $tp->setValue('totalj#' . ($i + 1), RelatorioVendaFuncionario::formatar($venda->tot_sem_desconto));
                $tp->setValue('descontoj#' . ($i + 1), RelatorioVendaFuncionario::formatar($venda->desconto));
                $tp->setValue('recebidoj#' . ($i + 1), RelatorioVendaFuncionario::formatar($venda->total));
                $i++;
            }
        }

        //alerta venda pf--------------------------------------------------------------------------------------
        $alertas = Alertaservico::find()->all();
        $cont_alert = 0;

        foreach ($alertas as $alerta){
            $data_aux = explode(" ", $alerta->data_pago);
            $data_venda = $data_aux[0];
            if(strtotime($inicio) <= strtotime($data_venda) && strtotime($data_venda) <= strtotime($fim)) {
                $cont_alert++;
            }
        }

        $tp->cloneRow('colaborador_alert', $cont_alert);

        $servicos = Servico::find()->all();
        $usuarios = Usuario::find()->all();
        $i = 0;

        $valor_servico = 0;

        foreach ($alertas as $alerta) {
            $data_aux = explode(" ", $alerta->data_pago);
            $data_venda = $data_aux[0];
            if (strtotime($inicio) <= strtotime($data_venda) && strtotime($data_venda) <= strtotime($fim)) {
                foreach ($usuarios as $usuario){
                    if($usuario->id == $alerta->usuario_fk){
                        $tp->setValue('colaborador_alert#' . ($i + 1), $usuario->nome);
                    }
                }

                foreach ($servicos as $servico) {
                    if ($servico->id == $alerta->servico_fk) {
                        $tp->setValue('servico_alert#' . ($i + 1), $servico->descricao);
                        $valor_servico = ($servico->valor * $alerta->quantidade);
                    }
                }

                $tp->setValue('quantidade_alert#' . ($i + 1), $alerta->quantidade);

                $tp->setValue('total_alert#' . ($i + 1), RelatorioVendaFuncionario::formatar($valor_servico));

                $tp->setValue('desconto_alert#' . ($i + 1), RelatorioVendaFuncionario::formatar(0));
                $tp->setValue('recebido_alert#' . ($i + 1), RelatorioVendaFuncionario::formatar($valor_servico));
                $i++;
            }
        }

        //alerta venda pJ--------------------------------------------------------------------------------------
        $alertasj = Alertaservicopj::find()->all();
        $cont_alertj = 0;

        foreach ($alertasj as $alertaj){
            $data_aux = explode(" ", $alertaj->data_pago);
            $data_venda = $data_aux[0];
            if(strtotime($inicio) <= strtotime($data_venda) && strtotime($data_venda) <= strtotime($fim)) {
                $cont_alertj++;
            }
        }

        $tp->cloneRow('colaborador_alertj', $cont_alertj);

        $servicos = Servico::find()->all();
        $usuarios = Usuario::find()->all();
        $i = 0;

        $valor_servico = 0;

        foreach ($alertasj as $alertaj) {
            $data_aux = explode(" ", $alertaj->data_pago);
            $data_venda = $data_aux[0];
            if (strtotime($inicio) <= strtotime($data_venda) && strtotime($data_venda) <= strtotime($fim)) {
                foreach ($usuarios as $usuario){
                    if($usuario->id == $alertaj->usuario_fk){
                        $tp->setValue('colaborador_alertj#' . ($i + 1), $usuario->nome);
                    }
                }

                foreach ($servicos as $servico) {
                    if ($servico->id == $alertaj->servico_fk) {
                        $tp->setValue('servico_alertj#' . ($i + 1), $servico->descricao);
                        $valor_servico = ($servico->valor * $alertaj->quantidade);
                    }
                }

                $tp->setValue('quantidade_alertj#' . ($i + 1), $alertaj->quantidade);

                $tp->setValue('total_alertj#' . ($i + 1), RelatorioVendaFuncionario::formatar($valor_servico));

                $tp->setValue('desconto_alertj#' . ($i + 1), RelatorioVendaFuncionario::formatar(0));
                $tp->setValue('recebido_alertj#' . ($i + 1), RelatorioVendaFuncionario::formatar($valor_servico));
                $i++;
            }
        }

        // Relatório total por funcionário---------------------------------------------------------------------
        $qtde_usuarios = count($usuarios);
        $tp->cloneRow('usuario', $qtde_usuarios);
        $aux=0;
        $maior_retorno = array();
        $nome_max =0;
        $nome_min =0;
        $valor_max=0;
        $valor_min = "1000000000";

        for($i=0; $i<$qtde_usuarios; $i++){
            $usuarios[$i];

            $num_venda = 0;
            $tot = 0;
            $totrece = 0;
            $destot = 0;

            $tp->setValue('usuario#' . ($aux + 1), $usuarios[$aux]->nome);

            for($j=0; $j<count($vendas); $j++){
                $data_aux = explode(" ", $vendas[$j]->data);
                $data_venda = $data_aux[0];
                if($usuarios[$i]->id == $vendas[$j]->usuario_fk && strtotime($inicio) <= strtotime($data_venda) && strtotime($data_venda) <= strtotime($fim)){
                    $num_venda++;
                    $tot += $vendas[$j]->tot_sem_desconto;
                    $destot += $vendas[$j]->desconto;
                    $totrece += $vendas[$j]->total;
                }
            }

            // somas os alertas pf
            $valor_servico_alerta =0;
            for($j=0; $j<count($alertas); $j++){
                $data_aux = explode(" ", $alertas[$j]->data_pago);
                $data_venda = $data_aux[0];
                if($usuarios[$i]->id == $alertas[$j]->usuario_fk && strtotime($inicio) <= strtotime($data_venda) && strtotime($data_venda) <= strtotime($fim)){
                    $num_venda++;

                    // pegar o valor do servico
                    foreach ($servicos as $servico){
                        if($servico->id == $alertas[$j]->servico_fk && strtotime($inicio) <= strtotime($data_venda) && strtotime($data_venda) <= strtotime($fim)){
                            $valor_servico_alerta = ($servico->valor * $alertas[$j]->quantidade);
                        }
                    }

                    $tot+= $valor_servico_alerta;
                    $totrece += $valor_servico_alerta;
                }
            }

            // soma vendas PJ
            for($j=0; $j<count($vendaspj); $j++){
                $data_aux = explode(" ", $vendaspj[$j]->data);
                $data_venda = $data_aux[0];
                if($usuarios[$i]->id == $vendaspj[$j]->usuario_fk && strtotime($inicio) <= strtotime($data_venda) && strtotime($data_venda) <= strtotime($fim)){
                    $num_venda++;
                    $tot += $vendaspj[$j]->tot_sem_desconto;
                    $destot += $vendaspj[$j]->desconto;
                    $totrece += $vendaspj[$j]->total;
                }
            }

            // somas os alertas pf
            $valor_servico_alertaj =0;
            for($j=0; $j<count($alertasj); $j++){
                $data_aux = explode(" ", $alertasj[$j]->data_pago);
                $data_venda = $data_aux[0];
                if($usuarios[$i]->id == $alertasj[$j]->usuario_fk && strtotime($inicio) <= strtotime($data_venda) && strtotime($data_venda) <= strtotime($fim)){
                    $num_venda++;

                    // pegar o valor do servico
                    foreach ($servicos as $servico){
                        if($servico->id == $alertasj[$j]->servico_fk && strtotime($inicio) <= strtotime($data_venda) && strtotime($data_venda) <= strtotime($fim)){
                            $valor_servico_alertaj = ($servico->valor * $alertasj[$j]->quantidade);
                        }
                    }

                    $tot+= $valor_servico_alertaj;
                    $totrece += $valor_servico_alertaj;
                }
            }
            $nome[$i] = $usuarios[$i]->nome;
            $maior_retorno[$i] = $totrece;

            $tp->setValue('num_venda#' . ($aux + 1), $num_venda);
            $tp->setValue('tot#' . ($aux + 1), RelatorioVendaFuncionario::formatar($tot));
            $tp->setValue('destot#' . ($aux + 1), RelatorioVendaFuncionario::formatar($destot));
            $tp->setValue('totrece#' . ($aux + 1), RelatorioVendaFuncionario::formatar($totrece));
            $aux++;
        }

        for ($k=0; $k<count($usuarios); $k++){
            if($maior_retorno[$k]>$valor_max){
                $valor_max = $maior_retorno[$k];
                $nome_max = $nome[$k];
            }

            if($valor_min>$maior_retorno[$k]){
                $valor_min = $maior_retorno[$k];
                $nome_min = $nome[$k];
            }
        }

        $tp->setValue('usermore', $nome_max);
        $tp->setValue('allmax', RelatorioVendaFuncionario::formatar($valor_max));
        $tp->setValue('userless', $nome_min);
        $tp->setValue('allmin', RelatorioVendaFuncionario::formatar($valor_min));
        $tp->setValue('inicio', RelatorioVendaFuncionario::formatData($inicio));
        $tp->setValue('fim', RelatorioVendaFuncionario::formatData($fim));

        $tp->saveAs(Yii::getAlias('@app') . '/documentos/relatorio_venda/relatorio_venda_temp.docx');
    }
}

