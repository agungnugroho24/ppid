<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermintaanInformasi;
use App\Models\StatusPermohonan;
use App\Models\LogPermintaanInformasi;
use App\Models\LogNomorPendaftaranPermintaanInformasi;
use App\Models\User;
use App\Models\SendEmail;
use App\Models\InformasiFrontOffice;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Notification;
use App\Notifications\RequestPPIDNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\SendEmailController;
use Purifier;

class PermintaanInformasiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->sendemail = new SendEmailController;        
    }
   
    protected $title = "Permintaan Informasi dan Dokumentasi";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = StatusPermohonan::whereNull('deleted_at')->get();
        return view('back-office.pages.informasidokumentasi_bo', ['title' => $this->title, 'status' => $status]);
    }   

    public function getLinkSurvey()
    {
        $query = InformasiFrontOffice::where('kategori', '=', 'Survey Layanan Informasi Publik')->where('is_publish', '=', 1)->whereNull('deleted_at')->get();

        if($query->isNotEmpty()):
            foreach($query as $row):
                $datalink = $row->data;
            endforeach;
            $link = $datalink;
        else:
            $link = route('no-link-survey');
        endif;
        return $link;
    }

    public function downloadFile($id)
    {
        // if( auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
        //     Alert::toast('Anda tidak memiliki wewenang untuk melakukan download file ini.', 'error');
        //     return redirect()->route('informasi-publik-bo');            
        // endif;

        // if( auth()->user()->hasAnyPermission(['confirm']) ):
        //     Alert::toast('Anda tidak memiliki wewenang untuk melakukan download file ini.', 'error');
        //     return redirect()->route('informasi-publik-bo');            
        // endif; 

        $query = PermintaanInformasi::findOrFail($id);
        
        if($query):
            $file = $query->dokumen_user;
        else:
            $file = NULL;
        endif;

        if($file):
            if(Storage::disk('private')->exists('dokumen_user_informasipublik/'.$file)):
                return response()->download(  storage_path('/app/private/dokumen_user_informasipublik/'.$file) );
            else:
                return abort(404);
            endif;
        else: 
            return redirect()->route('informasi-publik-bo'); 
        endif;
    }       

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {         
        $status = StatusPermohonan::whereNull('deleted_at')->get();
        return view('front-office.pages.informasi_dokumentasi');
    }

    public function show_dataprogres()
    {
        return view('front-office.pages.progres_permintaaninformasi');
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
            'nomor_pendaftaran' => 'required|unique:permintaan_informasi',
            'informasi_dibutuhkan' => 'required',
            'alasan_permintaan' => 'required',
            'alasan_penggunaan' => 'required',
            'bahan_informasi' => 'required',
            'dokumen' => 'required|mimes:pdf,jpeg|max:20480'
        ];

        $messages = [
            'informasi_dibutuhkan.required' => 'Field \':attribute\' tidak boleh kosong',
            'nomor_pendaftaran.required' => 'Field \':attribute\' tidak boleh kosong',
            'nomor_pendaftaran.unique' => 'Nomor pendaftaran tidak boleh sama, harus unique. Klik formulir untuk me-refresh nomor pendaftaran yang terbaru.',
            'alasan_permintaan.required' => 'Field \':attribute\' tidak boleh kosong',
            'alasan_penggunaan.required' => 'Field \':attribute\' tidak boleh kosong',
            'bahan_informasi.required' => 'Field \':attribute\' tidak boleh kosong',
            'dokumen.required' => 'Field \'lampiran\' tidak boleh kosong',
            'dokumen.mimes' => 'Data \'lampiran\' harus berformat jpeg atau pdf',
            'dokumen.max' => 'Ukuran file maksimal 2Mb',
        ];

        $this->validate($request, $rules, $messages);

        $dokumen = $request->file('dokumen');
        $original_filename = Str::replace(' ', '_', $request->namefile);
        $dok_name = $original_filename.'_'.date('d_F_Y_H_i_s').'.'.$dokumen->getClientOriginalExtension();             
        $dokumen->storeAs('private/dokumen_user_informasipublik', $dok_name);

        $status = 'Menunggu approval';
        // $keterangan = 'Menunggu admin memproses pengajuan';

        $data = array(
            'id_user' => $request->id_user,
            'nomor_pendaftaran' => $request->nomor_pendaftaran,
            'informasi_dibutuhkan' => Purifier::clean($request->informasi_dibutuhkan) ,
            'alasan_permintaan' => Purifier::clean($request->alasan_permintaan) ,
            'alasan_penggunaan' => Purifier::clean($request->alasan_penggunaan) ,
            'bahan_informasi' => Purifier::clean($request->bahan_informasi) ,
            'dokumen_user' => $dok_name,
            'status_permintaan' => $status,
            'keterangan' => NULL,
        );

        $query = PermintaanInformasi::create($data);
        $idInserted = $query->id;

        $datalog = array(
            'id_permintaaninformasi' => $idInserted,
            'tanggal_activity' => Carbon::now(),
            'status' => $status,
            'action' => "new insert",
            'id_user' => auth()->user()->id,
            'alasan_penolakan' => NULL,
        );   

        $this->storeLogPermintaanInformasi($datalog);      
        $this->storeNomorPendaftaran($request->nomor_urut);

        if($query):
            $sendnotif = $this->sendNotification($idInserted);
            Alert::toast('Permintaan Informasi dan Dokumentasi Berhasil Dikirim', 'success');
            return redirect()->route('informasi-publik');
        else:
            Alert::error('Gagal', 'Permintaan Informasi dan Dokumentasi Gagal Terkirim');
            return redirect()->route('informasi-publik');
        endif;

    }

    private function storeLogPermintaanInformasi($datalog)
    {
        $query = LogPermintaanInformasi::create($datalog);
    }

    public function getNoPendaftaran()
    {
        $formatNoPendaftaran = '/Req/PPID.01/'.Carbon::now()->format('m').'/'.Carbon::now()->year;
        
        $count = LogNomorPendaftaranPermintaanInformasi::all()->count();
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
            $getLastNumber = LogNomorPendaftaranPermintaanInformasi::get()->last();

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

        $query = LogNomorPendaftaranPermintaanInformasi::create($dataset);
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
            return redirect()->route('informasi-publik-bo');            
        endif;

        if(! auth()->user()->hasAnyPermission(['confirm']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update status permohonan.', 'error');
            return redirect()->route('informasi-publik-bo');            
        endif; 

        $status = $request->status_permintaan_informasi;
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
                    'status_permintaan' => $request->status_permintaan_informasi,
                    'alasan_penolakan' => $alasan,
                );                
            endif;
        endif;

        $query = PermintaanInformasi::find($id)->update($data);

        $datalog = array(
            'id_permintaaninformasi' => $id,
            'tanggal_activity' => Carbon::now(),
            'status' => $status,
            'action' => "update data",
            'id_user' => auth()->user()->id,
            'alasan_penolakan' => $alasan,
        );   

        $this->storeLogPermintaanInformasi($datalog);        

        if($query):
            Alert::toast('Update Data Status Permintaan Berhasil', 'success');
            return redirect()->route('informasi-publik-bo');
        else:
            Alert::toast('Update Data Status Permintaan Gagal.!', 'error');
            return redirect()->route('informasi-publik-bo');
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
        $data = DB::table('permintaan_informasi')
            ->join('users', 'users.id', '=', 'permintaan_informasi.id_user')
            ->select([
                'users.name',
                'users.email',
                'users.nomor_ponsel',
                'permintaan_informasi.nomor_pendaftaran',
                'permintaan_informasi.id',
                'permintaan_informasi.informasi_dibutuhkan',
                'permintaan_informasi.alasan_permintaan',
                'permintaan_informasi.alasan_penggunaan',
                'permintaan_informasi.bahan_informasi',
                'permintaan_informasi.dokumen_user',
                'permintaan_informasi.alasan_penolakan',
                'permintaan_informasi.status_permintaan',
                'permintaan_informasi.keterangan',
                'permintaan_informasi.created_at',
                'permintaan_informasi.updated_at'
            ])
            ->orderBy('permintaan_informasi.id', 'DESC')
            ->get();

        return DataTables::of($data)
            ->editColumn('created_at', function($data){ $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d-F-Y'); return $formatedDate; })
            ->addColumn('status_update', function($data){
                if(auth()->user()->hasPermissionTo('confirm')):
                    $statusupdated = "<button class='btn btn-primary' data-toggle='modal' data-target='#statusPermintaanModal'>Action</button>";
                else:
                    $statusupdated = "<button class='btn disabled btn-primary' style='cursor:not-allowed'>Action</button>";
                endif;     
                return $statusupdated;           
            })
            ->addColumn('route_status_update', function($data){
                $route_status_update = route('informasi-publik-bo-editstatus', ['id' =>$data->id]);    
                return $route_status_update;           
            })
            ->addColumn('path_lampiran', function($data){
                if(auth()->user()->hasPermissionTo('confirm')):
                    $path_lampiran = route('get-file-informasi-dokumentasi-publik', ['id' =>$data->id]);   
                else:
                    $path_lampiran = NULL;   
                endif;                 
                return $path_lampiran;           
            })       
            ->addColumn('informasi_dibutuhkan', function($data){
                $raw1 = Str::remove('<p>', $data->informasi_dibutuhkan);    
                $raw2 = Str::remove('</p>', $raw1);    
                return $raw2;           
            }) 
            ->addColumn('alasan_permintaan', function($data){
                $raw1 = Str::remove('<p>', $data->alasan_permintaan);    
                $raw2 = Str::remove('</p>', $raw1);    
                return $raw2;           
            }) 
            ->addColumn('alasan_penggunaan', function($data){
                $raw1 = Str::remove('<p>', $data->alasan_penggunaan);    
                $raw2 = Str::remove('</p>', $raw1);    
                return $raw2;           
            }) 
            ->addColumn('bahan_informasi', function($data){
                $raw1 = Str::remove('<p>', $data->bahan_informasi);    
                $raw2 = Str::remove('</p>', $raw1);    
                return $raw2;           
            })                                                                     
            ->rawColumns(['status_update','route_status_update'])             
            ->toJson();
    }

    public function getDatatablesJson_user()
    {
        $id_user = auth()->user()->id;
        $data = DB::table('permintaan_informasi')
            ->join('users', 'users.id', '=', 'permintaan_informasi.id_user')
            ->join('status_permohonan', 'status_permohonan.nama_status_singkat', '=', 'permintaan_informasi.status_permintaan')
            ->select([
                'users.name',
                'users.email',
                'users.nomor_ponsel',
                'status_permohonan.nama_status',
                'permintaan_informasi.nomor_pendaftaran',
                'permintaan_informasi.id',
                'permintaan_informasi.informasi_dibutuhkan',
                'permintaan_informasi.alasan_permintaan',
                'permintaan_informasi.alasan_penolakan',
                'permintaan_informasi.status_permintaan',
                'permintaan_informasi.keterangan',
                'permintaan_informasi.approved_by',
                'permintaan_informasi.created_at',
                'permintaan_informasi.updated_at',
                'permintaan_informasi.click_survey',
                'permintaan_informasi.confirm_survey'
            ])
            ->where('permintaan_informasi.id_user', $id_user)
            ->orderBy('permintaan_informasi.id', 'DESC')
            ->get();

        return DataTables::of($data)
            ->editColumn('created_at', function($data){ $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d-F-Y'); return $formatedDate; }) 
            ->addColumn('link_survey', function($data){
                $route_survey = $this->getLinkSurvey();
                $route_clicksurvey = route('informasi-publik-click-survey', ['id' =>$data->id]);
                $route_confirm = route('informasi-publik-confirm-survey', ['id' =>$data->id]);
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
            ->addColumn('informasi_dibutuhkan', function($data){
                $raw1 = Str::remove('<p>', $data->informasi_dibutuhkan);    
                $raw2 = Str::remove('</p>', $raw1);    
                return $raw2;           
            }) 
            ->addColumn('alasan_permintaan', function($data){
                $raw1 = Str::remove('<p>', $data->alasan_permintaan);    
                $raw2 = Str::remove('</p>', $raw1);    
                return $raw2;           
            })            
            ->rawColumns(['link_survey'])
            ->toJson();
    }

    public function sendNotification($id) 
    {
        $infoData = [
            'subject' => 'Notifikasi Permintaan Informasi',
            'name' => 'Permintaan Informasi',
            'body' => 'Anda mendapatkan notifikasi Permintaan Informasi',
            'thanks' => 'Terima Kasih',
            'text' => 'Data Detail',
            'url' => url('permohonan-informasi-publik/email/'.$id),
            'id' => $id,
        ];

        // $email = env('MAIL_FROM_ADDRESS');
        // $email = config('mail.to.address');
        // Notification::route('mail', $email)->notify(new RequestPPIDNotification($infoData));
        // $email = env('MAIL_FROM_ADDRESS');
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
        
        // $emails = ['bukantika@gmail.com', 'h.wafi21@gmail.com', 'muharam.aram@support.bappenas.go.id'];
    
    }

    public function dataNotif($id)
    {
        $title = "Detail Data Permintaan Informasi";
        $result = PermintaanInformasi::findOrFail($id);

        if(!empty($result)):
            $data = $result;
            $query = User::findOrFail($result['id_user']);
            $namapemohon = $query['name'];
        else:
            $data = NULL;
            $namapemohon = NULL;
        endif;

        return view('back-office.details.detail_email_informasidokumentasi', ['title' => $title, 'data' => $data, 'nama' => $namapemohon]);
    } 

    public function clickLinkSurvey(Request $request, $id)
    {
        $data = array(
            'click_survey' => 1,
        );                

        $query = PermintaanInformasi::find($id)->update($data);       

        if($query):
            return redirect()->away($this->getLinkSurvey());
        else:
            return redirect()->route('informasi-publik-progres');
        endif;        
    }

    public function confirmHasInputSurvey(Request $request, $id)
    {
        $data = array(
            'confirm_survey' => 1,
        );                

        $query = PermintaanInformasi::find($id)->update($data);       

        if($query):
            Alert::toast('Terima kasih telah mengisi survey layanan dari kami', 'success');
            return redirect()->route('informasi-publik-progres');
        else:
            Alert::toast('Konfirmasi pengisian survey Gagal.!', 'error');
            return redirect()->route('informasi-publik-progres');
        endif;          
    }   

}
