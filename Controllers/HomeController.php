<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\InformasiFrontOffice;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InformasiFrontOfficeController;
use Purifier;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);         
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {        
        return view('front-office.pages.home');
    }   

    public function updateprofile(Request $request)
    {
        return view('front-office.pages.edit_profil');
    } 

    public function update(Request $request, $id)
    {
        // dd($request);
        $rules = [
            'first_name' => 'required|regex:/^[A-Za-z ]+$/',
            'last_name' => 'required|regex:/^[A-Za-z ]+$/',
            'user_name' => 'required|unique:users|regex:/^[a-z.]+$/',
            'jenis_pemohon' => 'required',
            'email' => 'required|email',
            'jenis_identitas' => 'required',
            'nomor_identitas' => 'required|unique:users|regex:/^[A-Za-z0-9]+$/',
            'nomor_ponsel' => 'required|regex:/^[0-9]+$/',
            'keterangan' => 'required'
        ];

        $messages = [
            'first_name.required' => 'Field \':attribute\' tidak boleh kosong',
            'first_name.regex' => 'Field \':attribute\' hanya boleh menggunakan huruf dan spasi',
            'last_name.required' => 'Field \':attribute\' tidak boleh kosong',
            'last_name.regex' => 'Field \':attribute\' hanya boleh menggunakan huruf dan spasi',
            'user_name.required' => 'Field \':attribute\' tidak boleh kosong',
            'user_name.unique' => 'Username harus unique, tidak boleh sama dengan lainnya',
            'user_name.regex' => 'Username hanya boleh menggunakan titik dan huruf kecil',
            'jenis_pemohon.required' => 'Field \':attribute\' tidak boleh kosong',
            'email.required' => 'Field \':attribute\' tidak boleh kosong',
            'jenis_identitas.required' => 'Field \':attribute\' tidak boleh kosong',
            'nomor_identitas.required' => 'Field \':attribute\' tidak boleh kosong',
            'nomor_identitas.regex' => 'Field \':attribute\' hanya diperbolehkan menggunakan huruf & angka',
            'nomor_identitas.unique' => 'Nomor identitas harus unique, tidak boleh sama dengan lainnya',
            'nomor_ponsel.required' => 'Field \':attribute\' tidak boleh kosong',
            'nomor_ponsel.regex' => 'Field \':attribute\' hanya diperbolehkan menggunakan angka',
            'keterangan.required' => 'Field \':attribute\' tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages); 
        
        $data = array(
            'first_name' => $request->first_name ,
            'last_name' => $request->last_name ,
            'user_name' => $request->user_name ,
            'jenis_pemohon' => $request->jenis_pemohon,
            'email' => $request->email,
            'jenis_identitas' => $request->jenis_identitas,
            'nomor_identitas' => $request->nomor_identitas ,
            'nomor_ponsel' => $request->nomor_ponsel ,
            'keterangan' => Purifier::clean($request->keterangan) ,
        );

        $query = User::find($id)->update($data);

        if($query):
            Alert::toast('Update Data Profil Berhasil', 'success');
            return redirect()->route('home');
        else:
            Alert::toast('Update Data Profil Gagal.!', 'error');
            return redirect()->route('update-profile-update', $id);
        endif;              
    } 
  
    public function logoutCustom(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }      

}
