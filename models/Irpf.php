<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "irpf".
 *
 * @property int $id
 * @property int|null $cliente_fk
 * @property string|null $data_entrega
 * @property string|null $telefone
 */
class Irpf extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'irpf';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cliente_fk'], 'integer'],
            [['data_entrega'], 'safe'],
            [['telefone'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cliente_fk' => 'Cliente Fk',
            'data_entrega' => 'Data Entrega',
            'telefone' => 'Telefone',
        ];
    }

    public function geraEntrega($data){
        date_default_timezone_set('America/Sao_Paulo');
        $data_tabela = Irpf::find()->max('data_entrega');

        $data_explode = explode('-',$data_tabela);
        $ano = $data_explode[0];

        $irpfs = Irpf::find()->all();
        $clientes = Clienteavulso::find()->all();

        if($data > $ano){
            foreach ($irpfs as $irpf){
                $irpf->delete($irpf->id);
            }
            foreach ($clientes as $cliente){
                if($cliente->rotina == 2){
                    $model = new Irpf();
                    $model->cliente_fk = $cliente->id;
                    $data_entrega = "$data-04-30";
                    $model->data_entrega = $data_entrega;
                    $model->telefone = $cliente->telefone;
                    $model->save();
                }
            }
            return 1;
        }
    }

}
