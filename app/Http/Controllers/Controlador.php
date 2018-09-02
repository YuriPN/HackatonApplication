<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Controlador extends Controller
{
    function callAPI($method, $url, $data){
        $curl = curl_init();
     
        switch ($method){
           case "POST":
              curl_setopt($curl, CURLOPT_POST, 1);
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
              break;
           case "PUT":
              curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
              break;
           default:
              if ($data)
                 $url = sprintf("%s?%s", $url, http_build_query($data));
        }
     
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
           'APIKEY: ',
           'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
     
        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        return $result;
     }
     public function getCategorias(){
        $url = "http://virtus.azi.com.br/virtus-rest/v1/categorias";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL, $url);

        $result = curl_exec($ch);
        var_dump(json_decode($result, true));
     }

     public function getProtocolo(){
        $url = "http://virtus.azi.com.br/virtus-rest/v1/protocolos";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL, $url);

        $result = curl_exec($ch);
        $string = json_decode($result, true);
        var_dump($string['dados'][0]);
     }
     public function getProcesso(){
        $url = "http://virtus.azi.com.br/virtus-rest/v1/protocolos/processo";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL, $url);

        $result = curl_exec($ch);
        $string = json_decode($result, true);
        var_dump($string['dados'][0]);
     }
     
     public function criarDocumento(){
        $json_data = '{
            "protocolo": "936502012018",
            "numeroProcesso": "0400733746201801",
            "titulo": "ENCAMINHAMENTO",
            "descricao": "SISTEMA DE ACOMPANHAMENTO PSICOLÓGICO-UFMS, ENCAMINHAMENTO PARA PROFISSIONAL EXTERNO",
            "chaveCategoria": "[MOCHILA_VIAJANTE]SAPS-ENCAMINHAMENTO",
            "anexos": [
              {
                "nomeOriginal": "Encaminhamento para tratamento",
                "tipoMeio": "DIGITAL",
                "formato": "pdf",
                "chaveDeRecuperacaoDoDiretorio": "5b8b00a61c06060509d994c8",
                "versao": "1.0",
                "metadata": {
                  "additionalProp1": {},
                  "additionalProp2": {},
                  "additionalProp3": {}
                }
              }
            ],
            "atributos": {
              "additionalProp1": {},
              "additionalProp2": {},
              "additionalProp3": {}
            }
          }';
            
          $ch = curl_init('http://virtus.azi.com.br/virtus-rest/v1/documentos');                                                                      
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
          curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);                                                                  
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
              'Content-Type: application/json',                                                                                
              'Content-Length: ' . strlen($json_data))                                                                       
          );                                                                                                                   
                                                                                                                              
          $result = curl_exec($ch);
     }
     public function upload(){
        $url = "http://virtus.azi.com.br/virtus-rest/v1/arquivos";
        $headers = array('nome: ArquivoSAPS.pdf','mimetype: application/pdf',
        'numeroprocesso: 0400733746201801','chavecategoria: [MOCHILA_VIAJANTE]SAPS-ENCAMINHAMENTO',
        'protocolodoc: 936502012018','Content-Type: multipart/form-data');
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, array('file' => 'C:\Users\Yuri\Downloads\Gestão de Projetos - DomeS.pdf'));

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $responser = curl_exec($curl);
        var_dump($responser['key']);
        curl_close($curl);
     }
}
