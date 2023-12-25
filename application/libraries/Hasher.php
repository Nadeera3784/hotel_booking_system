<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hasher{

    private $key = "4MRNfXxAhlKLKcP28rKOeqL2mxpcLmTu";
    private $iv  = "1xIApVWwMRIpoPQb73DBWERvpVkqiOIi";
    private $encrypt_method = "AES-256-CBC";

    public function encrypt($string){
        $key = hash( 'sha256', $this->key);
        $iv = substr( hash('sha256', $this->iv), 0, 16 );
        $output = base64_encode( openssl_encrypt($string, $this->encrypt_method, $key, 0, $iv ));
        return $output;
    }

    public function decrypt($string){
        $key = hash('sha256', $this->key);
        $iv = substr(hash( 'sha256', $this->iv), 0, 16 );
        $output = openssl_decrypt(base64_decode( $string ), $this->encrypt_method, $key, 0, $iv );
        return $output;
    }
    

}

