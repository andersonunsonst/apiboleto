<?php

namespace App\Http\Controllers;

use App\Helpers\ApiBoleto;
use App\Models\ApiBoleto as ModelsApiBoleto;
use Illuminate\Http\Request;

class ApiBoletoController extends Controller
{
    public function index(Request $request)
    {
        $bar_code = $request->input('bar_code');
        $payment_date = $request->input('payment_date');
        if(empty($bar_code) ||  empty($payment_date)){
             [
                'code'      =>  403,
                'message'   =>  'Por favor informe um código de barras e uma data de vencimento'
             ];  

        }else{
            
            $boleto = (new ApiBoleto())->getDadosBoleto($bar_code, $payment_date); $boleto = (new ApiBoleto())->getDadosBoleto($bar_code, $payment_date);

            if($boleto->due_date < date('Y-m-d')){
       
               $multa =  $boleto->amount * 0.033;
               $juros = $boleto->amount * 0.2;
               $valor_final  = $boleto->amount + $multa + $juros;
               $valor =  $boleto->amount;
               $dadosCalculados = [ 'vencimento'=>$payment_date,'multa'=>$multa, 'juros'=>$juros, 'valor'=>$valor, 'valor_final'=>$valor_final];
               $this->save($dadosCalculados);
           }else{
               print 'boleto vencido';
           }
        }

    }

    private function save($dadosCalculados){
        
        $api = new ModelsApiBoleto();
        $api->multa = $dadosCalculados['multa'];
        $api->juros = $dadosCalculados['juros'];
        $api->valor = $dadosCalculados['valor'];
        $api->valor_final = $dadosCalculados['valor_final'];
        $api->save();

        echo json_encode([
                "original_amount"=> $dadosCalculados['valor'],
                "amount"=> $dadosCalculados['valor']+$dadosCalculados['multa'],
                "due_date"=> $dadosCalculados['vencimento'],
                "payment_date"=> date('Y-m-d'),
                "interest_amount_calculated"=> $dadosCalculados['juros'],
                "fine_amount_calculated"=> $dadosCalculados['valor_final']             
         ]);  
    }

}


