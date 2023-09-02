<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermohonanKunjungan;
use App\Models\StatusPermohonan;
use App\Models\LogPermohonanKunjungan;
use App\Models\LogNomorPendaftaranPermohonanKunjungan;
use App\Models\FormatSurat;
use App\Models\User;
use App\Models\InformasiFrontOffice;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Notification;
use App\Notifications\RequestPPIDNotification;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Http\Controllers\SendEmailController;
use Purifier;

class PermohonanKunjunganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->sendemail = new SendEmailController;         
    }    
    
    protected $title = "Permohonan Kunjungan Tamu";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = StatusPermohonan::whereNull('deleted_at')->get();
        return view('back-office.pages.permohonankunjungan_bo', ['title' => $this->title, 'status' => $status]);
    }

    public function getLinkSurvey()
    {
        $query = InformasiFrontOffice::where('kategori', '=', 'Survey Layanan Informasi Publik')->where('is_publish', '=', 1)->whereNull('deleted_at')->get();

        if($query->isNotEmpty()):
            $link = $query[0]->data;
        else:
            $link = "";
        endif;
        return $link;
    }         

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->get_form();
        $getresponseunitkerja = $this->getUnitKerja();
        $unitkerja = $getresponseunitkerja['data'];
        $status = $getresponseunitkerja['status'];
        return view('front-office.pages.kunjungan_tamu', ['path' => $data, 'unitkerja' => $unitkerja, 'status' => $status]);
    }

    public function show_dataprogres()
    {
        return view('front-office.pages.progres_kunjungantamu');
    }  

    public function get_form()
    {
        $query = FormatSurat::where('is_publish', '!=', 0)->whereNull('deleted_at')->get();
        if($query->count() > 1):
            $id = $query->max('id');
            $data = $query->where('id', '=', $id);
            foreach($data as $key):
                $file = $key->file;
            endforeach;
        elseif($query->count() == 1):
            $data = $query->first();
            $file = $data->file;
        else:
            $file = NULL;
        endif;

        if(empty($file)):
            $path = NULL;
        else:
            $path = Storage::url('template_surat_kunjungan/'.$file);
        endif;
        return $path;
    }  

    public function downloadForm()
    {
        $query = FormatSurat::where('is_publish', '!=', 0)->whereNull('deleted_at')->get();
        if($query->count() > 1):
            $id = $query->max('id');
            $data = $query->where('id', '=', $id);
            foreach($data as $key):
                $file = $key->file;
            endforeach;
        elseif($query->count() == 1):
            $data = $query->first();
            $file = $data->file;
        else:
            $file = NULL;
        endif;

        if(empty($file)):
            $path = NULL;
            return $path;        
        else: 
            return response()->download('storage/template_surat_kunjungan/'.$file);           
        endif;
    }

    public function downloadFile($id)
    {
        // if( auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
        //     Alert::toast('Anda tidak memiliki wewenang untuk melakukan download file ini.', 'error');
        //     return redirect()->route('kunjungan-tamu-bo');            
        // endif;

        // if( auth()->user()->hasAnyPermission(['confirm']) ):
        //     Alert::toast('Anda tidak memiliki wewenang untuk melakukan download file ini.', 'error');
        //     return redirect()->route('kunjungan-tamu-bo');            
        // endif; 

        $query = PermohonanKunjungan::findOrFail($id);
        
        if($query):
            $file = $query->dokumen_user;
        else:
            $file = NULL;
        endif;

        if($file):
            // return response()->download('public/storage/dokumen_user_kunjungan/'.$file);
            // $data = response()->download('public/storage/dokumen_user_kunjungan/'.$file);
            // ($data);

            if(Storage::disk('private')->exists('dokumen_user_kunjungan/'.$file)):
                return response()->download(  storage_path('/app/private/dokumen_user_kunjungan/'.$file) );
            else:
                return abort(404);
            endif;            
        else: 
            return redirect()->route('kunjungan-tamu-bo'); 
        endif;
    } 

    public function getUnitKerja()
    {
        $client = new Client();
        $url = 'https://api.bappenas.go.id/bus/api/domain/bsdm/unitkerja/';

        $response = Http::withHeaders([
            'authorization' => '55f956c711a7b49ed44f55a5e71f93b40d510dd4b41b2f6810a1d3ace39558e3ade5dd155c13ed424735bb34fea0d5af3e015070b62bfc8cdfd2807298f4f489',
            'Content-Type' => 'application/json; charset=utf-8'
        ])->post($url);  

        $responseBody = $response->body();
        $responseStatus = $response->status();
        $responseFailed = $response->failed();
        $responseCollect = $response->collect();
        
        if($responseStatus === 200):
            $data = $responseCollect['data'];
            $status = $responseStatus;
        else:
            $data = NULL;
            $status = $responseStatus;
        endif;

        return ['data' => $data, 'status' => $status ];  

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'id_user' => 'required',
            'nomor_pendaftaran' => 'required|unique:permohonan_kunjungan',
            'perihal_surat' => 'required',
            'tema_konsultasi' => 'required',
            'unitkerja_tujuan' => 'required',
            'waktu_kunjungan' => 'required',
            'jumlah_peserta' => 'required|numeric',
            'dokumen' => 'required|mimes:pdf|max:2048'
        ];

        $messages = [
            'nomor_pendaftaran.required' => 'Field \':attribute\' tidak boleh kosong',
            'nomor_pendaftaran.unique' => 'Nomor pendaftaran tidak boleh sama, harus unique. Klik formulir untuk me-refresh nomor pendaftaran yang terbaru.',
            'perihal_surat.required' => 'Field \':attribute\' tidak boleh kosong',
            'tema_konsultasi.required' => 'Field \':attribute\' tidak boleh kosong',
            'unitkerja_tujuan.required' => 'Field \':attribute\' tidak boleh kosong',
            'waktu_kunjungan.required' => 'Field \':attribute\' tidak boleh kosong',
            'jumlah_peserta.required' => 'Field \':attribute\' tidak boleh kosong',
            'jumlah_peserta.numeric' => 'Field \':attribute\' harus angka',
            'dokumen.required' => 'Field \'lampiran\' tidak boleh kosong',
            'dokumen.mimes' => 'Data \'lampiran\' harus berformat pdf',
            'dokumen.max' => 'Ukuran file size maksimal 2Mb',
        ];

        $this->validate($request, $rules, $messages);

        $dokumen = $request->file('dokumen');
        // $original_filename = $request->namefile;
        $original_filename = Str::replace(' ', '_', $request->namefile);
        $dok_name = $original_filename.'_'.date('d_F_Y_H_i_s').'.'.$dokumen->getClientOriginalExtension(); 
        $dokumen->storeAs('private/dokumen_user_kunjungan', $dok_name);

        $status = 'Menunggu approval';
        // $keterangan = 'Menunggu admin memproses pengajuan';

        $data = array(
            'id_user' => $request->id_user,
            'nomor_pendaftaran' => $request->nomor_pendaftaran,
            'perihal_surat' => Purifier::clean($request->perihal_surat) ,
            'tema_konsultasi' => Purifier::clean($request->tema_konsultasi) ,
            'unitkerja_tujuan' => $request->unitkerja_tujuan,
            'waktu_kunjungan' => $request->waktu_kunjungan,
            'jumlah_peserta' => $request->jumlah_peserta,
            'dokumen_user' => $dok_name,
            'status_permintaan' => $status,
            'keterangan' => NULL,
        );

        $query = PermohonanKunjungan::create($data);
        $idInserted = $query->id;

        $datalog = array(
            'id_permohonankunjungan' => $idInserted,
            'tanggal_activity' => Carbon::now(),
            'status' => $status,
            'action' => "new insert",
            'id_user' => auth()->user()->id,
            'alasan_penolakan' => NULL,
        );   

        $this->storeLogPermohonanKunjungan($datalog); 
        $this->storeNomorPendaftaran($request->nomor_urut);        

        if($query):
            $sendnotif = $this->sendNotification($idInserted);
            Alert::toast('Data Permohonan Kunjungan Berhasil Dikirim', 'success');            
            return redirect()->route('kunjungan-tamu');
        else:
            Alert::error('Gagal', 'Data Permohonan Kunjungan Gagal Terkirim');            
            return redirect()->route('kunjungan-tamu');
        endif;        
    }

    private function storeLogPermohonanKunjungan($datalog)
    {
        $query = LogPermohonanKunjungan::create($datalog);
    }  

    public function getNoPendaftaran()
    {
        $formatNoPendaftaran = '/Req/PPID.03/'.Carbon::now()->format('m').'/'.Carbon::now()->year;
        
        $count = LogNomorPendaftaranPermohonanKunjungan::all()->count();
        if($count === 0):
            $no_urut = (int) $count + 1;
            $no_pendaftaran = $no_urut.$formatNoPendaftaran;
            $data = array(
                'no_urut' => $no_urut,
                'no_pendaftaran' => $no_pendaftaran,
            );

            return $data;                                  
        endif;

        if($count > 0):
            $getLastNumber = LogNomorPendaftaranPermohonanKunjungan::get()->last();

            $created_last = $getLastNumber->created_at;
            $yearNow = Carbon::now()->year;
            $yearCreatedLast = (int) date("Y", strtotime($created_last));

            if($yearCreatedLast < $yearNow):
                $no_urut = (int) 1;
            else:
                $no_urut = (int) $getLastNumber->nomor_urut + 1;
            endif;

                $no_pendaftaran = $no_urut.$formatNoPendaftaran;
                $data = array(
                    'no_urut' => $no_urut,
                    'no_pendaftaran' => $no_pendaftaran,
                );

                return $data; 
        endif;
    }

    private function storeNomorPendaftaran($data)
    {
        $nomor_urut = $data;
        $dataset = array(
            'nomor_urut' => $nomor_urut,
            'created_at' => Carbon::now(),
        );

        $query = LogNomorPendaftaranPermohonanKunjungan::create($dataset);
    }      

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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

    public function updatestatus(Request $request, $id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update status permohonan.', 'error');
            return redirect()->route('kunjungan-tamu-bo');            
        endif;

        if(! auth()->user()->hasAnyPermission(['confirm']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update status permohonan.', 'error');
            return redirect()->route('kunjungan-tamu-bo');            
        endif; 

        $status = $request->status_permohonankunjungan;
        if(($status == "Ditolak oleh Unit Kerja") || ($status == "Ditolak oleh PPID")):
            $alasan = $request->alasan_penolakan;
        else:
            $alasan = NULL;
        endif;

        if(!empty($status)):
            if($status == "Diterima"):
                $approved_by = auth()->user()->name;
                $data = array(
                    'approved_by' => $approved_by,
                    'status_permintaan' => $status,
                    'alasan_penolakan' => $alasan,
                );                
            else:
                $data = array(
                    'status_permintaan' => $request->status_permohonankunjungan,
                    'alasan_penolakan' => $alasan,
                );                
            endif;
        endif;

        $query = PermohonanKunjungan::find($id)->update($data);

        $datalog = array(
            'id_permohonankunjungan' => $id,
            'tanggal_activity' => Carbon::now(),
            'status' => $status,
            'action' => "update data",
            'id_user' => auth()->user()->id,
            'alasan_penolakan' => $alasan,
        );   

        $this->storeLogPermohonanKunjungan($datalog);        

        if($query):
            Alert::toast('Update Data Status Permintaan Berhasil', 'success');
            return redirect()->route('kunjungan-tamu-bo');
        else:
            Alert::toast('Update Data Status Permintaan Gagal.!', 'error');
            return redirect()->route('kunjungan-tamu-bo');
        endif;        
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

    public function getDatatablesJson()
    {
        $data = DB::table('permohonan_kunjungan')
            ->join('users', 'users.id', '=', 'permohonan_kunjungan.id_user')
            ->select([
                'users.name',
                'users.email',
                'permohonan_kunjungan.id',
                'permohonan_kunjungan.nomor_pendaftaran',
                'permohonan_kunjungan.perihal_surat',
                'permohonan_kunjungan.tema_konsultasi',
                'permohonan_kunjungan.unitkerja_tujuan',
                'permohonan_kunjungan.waktu_kunjungan',
                'permohonan_kunjungan.jumlah_peserta',
                'permohonan_kunjungan.status_permintaan',
                'permohonan_kunjungan.dokumen_user',
                'permohonan_kunjungan.alasan_penolakan',
                'permohonan_kunjungan.keterangan',
                'permohonan_kunjungan.approved_by',
                'permohonan_kunjungan.created_at',
                'permohonan_kunjungan.updated_at'
            ])
            ->orderBy('permohonan_kunjungan.id', 'DESC')
            ->get();

        return DataTables::of($data)
            ->editColumn('created_at', function($data){ $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d-F-Y'); return $formatedDate; })
            ->editColumn('waktu_kunjungan', function($data){ $waktuKunjungan = date("d/m/Y", strtotime($data->waktu_kunjungan)); return $waktuKunjungan; })            
            ->addColumn('status_update', function($data){
                if(auth()->user()->hasPermissionTo('confirm')):
                    $statusupdated = "<button class='btn btn-primary' data-toggle='modal' data-target='#statusPermohonanKunjungaModal'>Action</button>";
                else:
                    $statusupdated = "<button class='btn disabled btn-primary' style='cursor:not-allowed'>Action</button>";
                endif;     
                return $statusupdated;           
            })
            ->addColumn('route_status_update', function($data){
                $route_status_update = route('kunjungan-tamu-bo-editstatus', ['id' =>$data->id]);    
                return $route_status_update;           
            })  
            ->addColumn('path_lampiran', function($data){
                if(auth()->user()->hasPermissionTo('confirm')):
                    $path_lampiran = route('get-file-permohonan-kunjungan-tamu', ['id' =>$data->id]);   
                else:
                    $path_lampiran = NULL;   
                endif;                 
                return $path_lampiran;                    
            })   
            ->addColumn('perihal_surat', function($data){
                $raw1 = Str::remove('<p>', $data->perihal_surat);    
                $raw2 = Str::remove('</p>', $raw1);    
                return $raw2;           
            }) 
            ->addColumn('tema_konsultasi', function($data){
                $raw1 = Str::remove('<p>', $data->tema_konsultasi);    
                $raw2 = Str::remove('</p>', $raw1);    
                return $raw2;           
            })                                                
            ->rawColumns(['status_update','route_status_update'])         
        ->toJson();
    } 

    public function getDatatablesJson_user()
    {
        $id_user = auth()->user()->id;
        $data = DB::table('permohonan_kunjungan')
            ->join('users', 'users.id', '=', 'permohonan_kunjungan.id_user')
                        ->join('status_permohonan', 'status_permohonan.nama_status_singkat', '=', 'permohonan_kunjungan.status_permintaan')
            ->select([
                'users.name',
                'users.email',
                'status_permohonan.nama_status',
                'permohonan_kunjungan.id',
                'permohonan_kunjungan.nomor_pendaftaran',
                'permohonan_kunjungan.perihal_surat',
                'permohonan_kunjungan.tema_konsultasi',
                'permohonan_kunjungan.unitkerja_tujuan',
                'permohonan_kunjungan.waktu_kunjungan',
                'permohonan_kunjungan.jumlah_peserta',
                'permohonan_kunjungan.status_permintaan',
                'permohonan_kunjungan.alasan_penolakan',
                'permohonan_kunjungan.keterangan',
                'permohonan_kunjungan.approved_by',
                'permohonan_kunjungan.created_at',
                'permohonan_kunjungan.updated_at',
                'permohonan_kunjungan.click_survey',
                'permohonan_kunjungan.confirm_survey'
            ])
            ->where('permohonan_kunjungan.id_user', $id_user)
            ->orderBy('permohonan_kunjungan.id', 'DESC')
            ->get();

            // dd($data);

        return DataTables::of($data)
            ->editColumn('created_at', function($data){ $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d-F-Y'); return $formatedDate; })
            ->addColumn('link_survey', function($data){
                $route_survey = $this->getLinkSurvey();
                $route_clicksurvey = route('kunjungan-tamu-click-survey', ['id' =>$data->id]);
                $route_confirm = route('kunjungan-tamu-confirm-survey', ['id' =>$data->id]);
                $status_permintaan = $data->status_permintaan;   
                $click_survey = (int) $data->click_survey;   
                $confirm_survey = (int) $data->confirm_survey;
                $row = '<div class="text-danger font-weight-bold">Link survey belum tersedia</div>';

                if(($status_permintaan === "Selesai") && ($click_survey === 0 )):
                    $row = "<div><span class='font-weight-bold'>Silahkan isi link survey berikut : </span><a href='".$route_clicksurvey."' target='_blank'>".$route_survey."</a></div>";

                elseif(($status_permintaan === "Selesai") && ($click_survey === 1 ) && ($confirm_survey === 0 )):
                    $row = "<div class='font-weight-bold'>Apakah anda sudah mengisi form survey?</div><div><a href='".$route_survey."' target='_blank' class='btn btn-danger btn-sm confirm-no mb-2'>Belum</a> &nbsp; <a href='".$route_confirm."' class='btn btn-success btn-sm confirm-yes mb-2'>Sudah</a></div></div>";

                elseif(($status_permintaan === "Selesai") && ($click_survey === 1 ) && ($confirm_survey === 1 )):
                    $row = "<div class='text-success font-weight-bold'>Terima kasih telah mengisi survey dari kami</div>";
                endif; 

                return $row;            
            })   
            ->addColumn('perihal_surat', function($data){
                $raw1 = Str::remove('<p>', $data->perihal_surat);    
                $raw2 = Str::remove('</p>', $raw1);    
                return $raw2;           
            }) 
            ->addColumn('tema_konsultasi', function($data){
                $raw1 = Str::remove('<p>', $data->tema_konsultasi);    
                $raw2 = Str::remove('</p>', $raw1);    
                return $raw2;           
            })            
            ->rawColumns(['link_survey'])            
            ->toJson();
    }   

    public function sendNotification($id) 
    {
        $infoData = [
            'subject' => 'Notifikasi Permohonan Kunjungan',
            'name' => 'Permohonan Kunjungan',
            'body' => 'Anda mendapatkan notifikasi Permohonan Kunjungan',
            'thanks' => 'Terima Kasih',
            'text' => 'Data Detail',
            'url' => url('permohonan-kunjungan-tamu/email/'.$id),
            'id' => $id,
        ];

        // $email = env('MAIL_FROM_ADDRESS'); //Tujuan emailnya
        // $email = config('mail.to.address'); //Tujuan emailnya
        // Notification::route('mail', $email)->notify(new RequestPPIDNotification($infoData));

        $emails = $this->sendemail->getDataKirimNotifikasiEmail();

        if(!empty($emails)):
            if(is_array($emails)){
                foreach($emails as $recipient){
                    Notification::route('mail', $recipient)->notify(new RequestPPIDNotification($infoData));
                }
            }else{
                Notification::route('mail', $emails)->notify(new RequestPPIDNotification($infoData));
            }            
        else:
                $default_emails = env("MAIL_FROM_ADDRESS"); 
                Notification::route('mail', $default_emails)->notify(new RequestPPIDNotification($infoData));
        endif;
        
    }

    public function dataNotif($id)
    {
        $title = "Detail Data Permohonan Kunjungan";
        $result = PermohonanKunjungan::findOrFail($id);

        if(!empty($result)):
            $data = $result;
            $query = User::findOrFail($result['id_user']);
            $namapemohon = $query['name'];
        else:
            $data = NULL;
            $namapemohon = NULL;
        endif;

        return view('back-office.details.detail_email_permohonankunjungan', ['title' => $title, 'data' => $data, 'nama' => $namapemohon]);        
    }

    public function clickLinkSurvey(Request $request, $id)
    {
        $data = array(
            'click_survey' => 1,
        );                

        $query = PermohonanKunjungan::find($id)->update($data);       

        if($query):
            return redirect()->away($this->getLinkSurvey());
        else:
            return redirect()->route('kunjungan-tamu-progres');
        endif;        
    }

    public function confirmHasInputSurvey(Request $request, $id)
    {
        $data = array(
            'confirm_survey' => 1,
        );                

        $query = PermohonanKunjungan::find($id)->update($data);       

        if($query):
            Alert::toast('Terima kasih telah mengisi survey layanan dari kami', 'success');
            return redirect()->route('kunjungan-tamu-progres');
        else:
            Alert::toast('Konfirmasi pengisian survey Gagal.!', 'error');
            return redirect()->route('kunjungan-tamu-progres');
        endif;          
    } 

}
