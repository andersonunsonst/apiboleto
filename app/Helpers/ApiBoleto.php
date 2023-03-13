<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class ApiBoleto
{
    private $api;
    private $client;
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
        $body['client_id'] = 'bd753592-cf9b-4d1a-96b9-cb8b2c01bd12';
        $body['client_secret'] = '4e8229fe-1131-439c-9846-799895a8be5b';
        
        $res = $this->client->request('POST', 'https://vagas.builders/api/builders/auth/tokens', 
        [
            'headers'=>array('Content-Type'=>'application/json'), 
            'json' => $body
         ]);
        
        $this->api = json_decode($res->getBody()->getContents());
    }


    public function getDadosBoleto($bar_code){
        try {
            $res_code =  $this->client->request('POST', 'https://vagas.builders/api/builders/bill-payments/codes',
            [
                'headers'=>[
                    'Content-Type'=>'application/json',
                    'Authorization' =>$this->api->token
                ], 
                'json' => [
                    'code'=>$bar_code
                ]
            ] 
            );
    
            return json_decode($res_code->getBody()->getContents());
        }
        catch (\Throwable $t) {
           echo json_encode( 
            [
                'code'      =>  403,
                'message'   =>  'Código Inválido'
             ]);  
            exit;
        }
      
    }
}