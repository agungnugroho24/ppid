<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\LibSSOController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response;
use Session;
use Illuminate\Support\Facades\Session as Session2;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use RealRashid\SweetAlert\Facades\Alert;

class LoginSSOController extends Controller
{
    use AuthenticatesUsers;
    
    var $app        = 'ppidbappenas';
    var $apikey     = 'kVcZ8P+hS3xT41xE9c8aHb2+jRiE7FmFqbLbkEgWZi0neduDC00Elzt4xcP35VkG5FKJm13qIk4KN8ER0X1Uhg==';
    var $sess_id    = '';

    public function __construct()
    {
        
        $data = session('ppidsso');
        if(! empty($data)){
            $login = $data["login"];
            if($login):
                return redirect()->route('front-office');
            else:
                return redirect()->route('front-office'); 
            endif;            
        }
        
        $this->middleware('guest')->except('logout');

    }  

    public function login(){
        $libcontrol = new LibSSOController;
        $data = $libcontrol->getData();

        if(empty($data->data)){
            
            return redirect()->to('https://akun.bappenas.go.id/bp-um/service/front/ppidbappenas/kVcZ8P+hS3xT41xE9c8aHb2+jRiE7FmFqbLbkEgWZi0neduDC00Elzt4xcP35VkG5FKJm13qIk4KN8ER0X1Uhg==')->send();

        }else{
            if(empty($data->userdata)){
                $this->logout();
            }else{
                $response = $this->process_login($data->userdata, $data->usermail);
                
                if($response):
                    
                    return redirect()->route('home');
                else:
                    return redirect()->route('front-office'); 
                endif;
                
            }
        }
    }

    public function index(Request $request){
        return $this->login();
    }

    private function process_login($userdata, $email){
        // ini_set('display_errors', 1);
        $libcontrol = new LibSSOController;
        $request = new Request;

        //get user
        // $uid  = $userdata[0]->user_name;
        // $cond = "username = '$uid'";
        

        //end checking user status
        $newdata = array( 'username'    => $userdata[0]->user_name,
                          'email'       => $email,
                          'nama'        => $userdata[0]->nama,
                          'nip'         => $userdata[0]->nip,
                          'jabatan'     => $userdata[0]->jabatan_akhir,
                          //'role'      => $role,
                          'kode_surat'  => $userdata[0]->kode_surat,
                          'iduke'       => $userdata[0]->id_unitkerja,
                          'nama_uke'    => $userdata[0]->unit_kerja,
                          'avatar'      => $userdata[0]->avatar,
                          'isorganik'   => $userdata[0]->isorganik,
                          'userapp'     => $libcontrol->getUserapp(),
                          'login'       => TRUE,
                    );

        Session::put('ppidsso', $newdata);
        $data = session('ppidsso');
        $login = $data["login"];      
        
        if($login):
            $check_user = $this->getDataUserPPID();
            $check_user_exist = $check_user['status'];
            
            if($check_user_exist):
                $data_user = $check_user['data'];
                foreach($data_user as $row):
                    $iduser = $row->id;
                endforeach;

                Auth::loginUsingId($iduser);
                
            else:
                $data_input = $this->storeUserBappenas($newdata);
                Auth::login( $data_input, true );
                
            endif;
            Alert::toast('Anda berhasil login', 'success');
            return redirect()->route('home');
            // return TRUE;
        else:
            return FALSE; 
        endif;
    }
    
    public function getDataUserPPID()
    {
        $sess_key = session('ppidsso');
        if(isset($sess_key)):
            $data = session('ppidsso');
            $username = $data['username'];
            $email = $data['email'];
        else:
            $username = NULL;
            $email = NULL;
        endif;
        
        $query = User::where('email', '=',$email)->get();

        if($query->isNotEmpty()):
            $status = TRUE;
            $data = $query;
        
        else:
            $status = FALSE;
            $data = NULL;            
            
        endif;
        
        return ['status' => $status, 'data' => $data];
    }
    
    private function storeUserBappenas($data)
    {
        
        $data_input = [   
            'name' => $data['nama'] ,
            'first_name' => NULL ,
            'last_name' => NULL ,
            'email' => $data['email'],
            'nomor_ponsel' => NULL ,
            'password' => NULL,
            'user_name' => $data['username'],
            'jenis_pemohon' => NULL,
            'jenis_identitas' => NULL,
            'nomor_identitas' => NULL,
            'nomor_ponsel' => NULL,
            'alamat' => NULL,
            'pekerjaan' => NULL,
            'keterangan' => NULL,
            'instansi' => $data['nama_uke'],
            'email_verified_at' => Carbon::now(),
            'is_active' => 1,
            'is_bappenas' => 1,
        ];
        
        $user_bappenas = User::create($data_input);

        $user_bappenas->assignRole('user'); 
        
        return $user_bappenas;
    }

    public function logout(Request $request){
        
        $libcontrol = new LibSSOController;
        $libcontrol->deleteSession();
        Session::flush();
        $request->session()->invalidate();

        return redirect()->route('front-office');
    } 
    
    // public function authenticate(Request $request){
    //   $email=$request->get('email');
    //   if (Auth::attempt(['email' => $email]))
    //     {     
    //         return redirect()->intended('/');   
    //     }
    //     else 
    //     {
    //         return redirect('/login');
    //     }
    
    // }    
    

    

}
