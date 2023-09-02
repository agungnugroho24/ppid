<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InformasiFrontOffice;
use App\Models\PostKontenProfil;
use App\Models\PostKontenBerita;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class FrontOfficeController extends Controller
{
    public function __construct()
    {
        //
    }    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $data = $this->getDataBerita();

        // insert data ke table visitor
    	DB::table('visitor')->insertOrIgnore([
    		'ip' => $_SERVER['REMOTE_ADDR'],
    		'date' => date("Y-m-d")
    	]);
    	
    	$visitor=DB::table('visitor')->count();
        $jumlah_PI=DB::table('permintaan_informasi')->count();

        return view('front-office.pages.index', ['databerita' => $data, 'jumlah_PI' => $jumlah_PI, 'visitor' => $visitor]);
    }

    public function tentang()
    {
        $menu = 'Tentang';
        $data = $this->getDataKontenProfil($menu);
        return view('front-office.pages.tentang', ['data' => $data]);
    }     

    public function tugasfungsi()
    {
        $menu = 'Tugas dan Fungsi';
        $data = $this->getDataKontenProfil($menu);        
        return view('front-office.pages.tugas_fungsi', ['data' => $data]);
    }    

    public function visimisi()
    {
        $menu = 'Visi dan Misi';
        $data = $this->getDataKontenProfil($menu);        
        return view('front-office.pages.visi_misi', ['data' => $data]);
    }  

    public function struktur()
    {
        $menu = 'Struktur';
        $data = $this->getDataKontenProfil($menu);        
        return view('front-office.pages.struktur', ['data' => $data]);
    }  

    public function regulasi()
    {
        $menu = 'Regulasi';
        $data = $this->getDataKontenProfil($menu);        
        return view('front-office.pages.regulasi', ['data' => $data]);
    }

    public function maklumatpelayanan()
    {
        $menu = 'Maklumat Pelayanan';
        $data = $this->getDataKontenProfil($menu);        
        return view('front-office.pages.maklumat_pelayanan', ['data' => $data]);
    }

    public function mekanismepermohonan()
    {
        $menu = 'Mekanisme Permohonan';
        $data = $this->getDataKontenProfil($menu);        
        return view('front-office.pages.mekanisme_permohonan', ['data' => $data]);
    }

    public function mekanismekeberatan()
    {
        $menu = 'Mekanisme Keberatan';
        $data = $this->getDataKontenProfil($menu);        
        return view('front-office.pages.mekanisme_keberatan', ['data' => $data]);
    }

    public function mekanismesengketa()
    {
        $menu = 'Mekanisme Sengketa';
        $data = $this->getDataKontenProfil($menu);        
        return view('front-office.pages.mekanisme_sengketa', ['data' => $data]);
    }                          

    public function waktupelayanan()
    {
        $menu = 'Waktu Pelayanan';
        $data = $this->getDataKontenProfil($menu);        
        return view('front-office.pages.waktu_pelayanan', ['data' => $data]);
    }                          

    public function standarbiaya()
    {
        $menu = 'Standar Biaya';
        $data = $this->getDataKontenProfil($menu);        
        return view('front-office.pages.standar_biaya', ['data' => $data]);
    }                          

    public function kebijakanprivasi()
    {
        $menu = 'Kebijakan Privasi';
        $data = $this->getDataKontenProfil($menu);        
        return view('front-office.pages.kebijakan_privasi', ['data' => $data]);
    }  

    public function showberita($uuid)
    {
        $data = $this->getDataShowDetailBerita($uuid);         
        return view('front-office.pages.berita', ['data' => $data]);
    }   

    public function getDataShowDetailBerita($uuid)
    {
        $query = PostKontenBerita::where('uuid_code',$uuid)->get();
        if($query->isNotEmpty()):
            foreach($query as $row):
                $judul = $row->judul;
                $isi_konten = $row->isi_konten;
                $konten_pendek = $row->konten_pendek;
                $tanggalpost = date("d F, Y", strtotime($row->created_at));
                $penulis = 'Admin';
                $thumbnail = asset('storage/post_berita/'.$row->thumbnail);
            endforeach;

            $data = [ 'judul' => $judul, 'isi_konten' => $isi_konten, 'konten_pendek' => $konten_pendek,
                'tanggalpost' => $tanggalpost, 'penulis' => $penulis, 'thumbnail' => $thumbnail,
            ]; 
        else:
            $data = null;
        endif;

        return $data;
    }           

    public function pageInactiveUser()
    {
        return view('errors.inactiveuser_pages');
    } 

    public function getDataKontenProfil($menu)
    {
        $query = PostKontenProfil::where('menu', $menu)->where('is_publish', '=', 1)->whereNull('deleted_at')->get();
        if($query->isNotEmpty()):
            $data = $query;
        else:
            $data = NULL;
        endif;        

        return $data;        
    }  

    public function getDataBerita()
    {
        $query = PostKontenBerita::where('is_publish', '=', 1)->whereNull('deleted_at')->get();

        if($query->isNotEmpty()):
            $data = $query;
        else:
            $data = NULL;
        endif;        

        return $data;        
    }                         

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
            // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function instagram(){
		return view('front-office.pages.instagram');
	}
}
