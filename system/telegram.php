<?php
    class Telegram{
        private $address;
        public function __construct($token){
            $uri = 'https://api.telegram.org/bot';
            $this->address = $uri.$token;
        }

        public function getUpdates($getEndMessage = false){
            $done = file_get_contents($this->address.'/getUpdates');
            $result = json_decode($done , true);
            if($getEndMessage){
                return end($result['result']);
            }
            return $result['result'];
        }

        public function sendMsg($message = array()){
            $curl = curl_init();
            curl_setopt($curl , CURLOPT_URL , $this->address.'/sendMessage'); // url
            curl_setopt($curl , CURLOPT_RETURNTRANSFER , 1); // transfer data
            curl_setopt($curl , CURLOPT_POSTFIELDS , http_build_query($message));
            $result = curl_exec($curl);
            if($result){
                return $result;
            }
            return curl_error($curl) . ' | ' . curl_errno($curl);
        }

        public function webHook($fileAddress){

        }

    } // end of class

?>