<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response;

class LibSSOController extends Controller
{

    var $app        = 'ppidbappenas';
    var $apikey     = 'kVcZ8P+hS3xT41xE9c8aHb2+jRiE7FmFqbLbkEgWZi0neduDC00Elzt4xcP35VkG5FKJm13qIk4KN8ER0X1Uhg==';
    var $sess_id    = '';


    public function __construct()
    {
        if(! isset($_COOKIE['um-bp'])):
            $this->sess_id = null;
        else:
            $cookies = $_COOKIE['um-bp']; 
            $this->sess_id = substr($cookies, strpos($cookies, "32:") + 4, 32);            
        endif;

        return $this->sess_id;
    }
    
    public function index()
    {
        // echo $this->sess_id;
        $data = $this->getData();
        dd($data);
    }

    public function ceksess()
    {
        if(! isset($_COOKIE['um-bp'])):
            $val = null;
        else:
            $cookies = $_COOKIE['um-bp']; 
            $val = $cookies;            
        endif;
        
        dd($val);       
    }   
    
    public function removesess()
    {
        if(! isset($_COOKIE['um-bp'])):
            $val = 'tidak ada';
        else:
            unset($_COOKIE["um-bp"]); 
            $val = $this->ceksess();            
        endif;
        
        dd($val);       
    }    
    
    public function idsess()
    {
        $val = $this->sess_id;  
        dd($val);
    }
    
    public function datasess()
    {
        $val = session('ppidsso');
        dd($val);
    }  
    
    public function getdatasess(){
        if(isset(session('ppidsso')['email'])):
            $data = session('ppidsso')['email'];
        else:
            $data = 'no data';
        endif;
        // $email = $data["email"];
        echo $data;
    }
    
    public function idcook()
    {
        $val = $this->sess_id;  
        dd($val);
    }

    public function setCookies(){
        if(! isset($_COOKIE['um-bp'])):
            $this->sess_id = null;
        else:
            $cookies = $_COOKIE['um-bp']; 
            $this->sess_id = substr($cookies, strpos($cookies, "32:") + 4, 32);            
        endif;

        return $this->sess_id;
    }

    public function getData(){
        $sess_id = $this->setCookies();
        $isian = array( 'session' => $sess_id,
                        'app'      => $this->app,
                        'apikey'   => $this->apikey);
        $url = "https://akun.bappenas.go.id/bp-um/service/checkSession";
        return $this->postData($isian, $url);
    } 

    public function deleteSession(){
        $isian = array( 'session' => $this->sess_id,
                        'app'      => $this->app,
                        'apikey'   => $this->apikey);
        $url = "https://akun.bappenas.go.id/bp-um/service/deleteSession";
        unset($_COOKIE["um-bp"]);
        return $this->postData($isian, $url);
        
    }

    public function getOneStepAhead($username){
        if(!empty($username)){
            $isian = array( 'username' => $username,
                            'app'      => $this->app,
                            'apikey'   => $this->apikey);
            $url = "https://akun.bappenas.go.id/bp-um/service/getUserBoss";
            //unset($_COOKIE["um-bp"]);
            return $this->postData($isian, $url);
        }else{
            return false;
        }
    }

    public function getUserapp(){
        $isian = array( 'username' => $this->getData()->data[0]->userid,
                        'app'      => $this->app,
                        'apikey'   => $this->apikey);
        $url = "https://akun.bappenas.go.id/bp-um/service/getUserApp";
        return $this->postData($isian, $url);
    }

    public function getuserdata($uid){
        $isian = array( 'username' => $uid,
                        'app'      => $this->app,
                        'apikey'   => $this->apikey);
        $url = "https://akun.bappenas.go.id/bp-um/service/checkUser";
        return $this->postData($isian, $url);
    }

    private function postData($data, $url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec ($ch);
        curl_close ($ch);
        $hasil = json_decode($output);
        return $hasil;
    }



}
