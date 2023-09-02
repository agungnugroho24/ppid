<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rules\Password;
use Purifier;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nomor_ponsel' => ['required', 'regex:/^[0-9]+$/', 'min:7', 'max:15'],
            'password' => ['required', 'string', 'confirmed', Password::min(10)->mixedCase()->symbols()->numbers()],
            'captcha' => ['required','captcha'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]; 

        $messages = [
            'first_name.required' => 'Field \':attribute\' tidak boleh kosong',
            'last_name.required' => 'Field \':attribute\' tidak boleh kosong',
            'email.required' => 'Field \':attribute\' tidak boleh kosong',
            'email.unique' => '\':attribute\' sudah terdaftar/telah digunakan',
            'password.required' => 'Field \':attribute\' tidak boleh kosong',
            'password.min' => 'Field \':attribute\' minimal 8 karakter',
            'nomor_ponsel.required' => 'Field \':attribute\' tidak boleh kosong',
            'nomor_ponsel.min' => 'Jumlah digit nomor telepon yang anda masukkan kurang',
            'nomor_ponsel.max' => 'Jumlah digit nomor telepon yang anda masukkan terlalu banyak',
            'nomor_ponsel.regex' => 'Field \':attribute\' harus berupa angka',
            'captcha.required' => 'Captcha tidak boleh kosong',
            'captcha.captcha' => 'Captcha yang ada masukkan tidak sesuai.!',
        ]; 

        return Validator::make($data, $rules, $messages );
            // = [
        //     'first_name' => ['required', 'string', 'max:255'],
        //     'last_name' => ['required', 'string', 'max:255'],
        //     // 'user_name' => ['required', 'string', 'regex:/^[a-z.]+$/', 'max:100', 'unique:users'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     // 'nomor_identitas' => ['required', 'string', 'max:100', 'unique:users'],
        //     'nomor_ponsel' => ['required', 'regex:/^[0-9]+$/', 'max:15'],
        //     // 'pekerjaan' => ['required', 'string', 'max:100'],
        //     // 'instansi' => ['required', 'string', 'max:255'],
        //     'password' => ['required', 'string', 'min:8', 'confirmed'],
        // ]
        // );

        // return $this->validate($data, $rules, $messages);
    }

    public function reloadCaptcha()
    {
        $data = response()->json(['captcha'=> captcha_img('flat')]);
        return response()->json(['captcha'=> captcha_img('flat')]);
    }    

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if(empty($data['last_name'])){
            $last_name = '';
        }

        $fullname = $data['first_name']." ".$data['last_name'];
        $user = User::create([
            'name' => $fullname ,
            'first_name' => $data['first_name'] ,
            'last_name' => $data['last_name'] ,
            'email' => $data['email'],
            'nomor_ponsel' => $data['nomor_ponsel'],
            'password' => Hash::make($data['password']),

        ]);

        $user->assignRole('user'); 

        return $user; 
    }

}

