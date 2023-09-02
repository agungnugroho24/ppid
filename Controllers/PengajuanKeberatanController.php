<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanKeberatan;
use App\Models\StatusPermohonan;
use App\Models\LogPengajuanKeberatan;
use App\Models\LogNomorPendaftaranPengajuanKeberatan;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Notification;
use App\Notifications\RequestPPIDNotification;
use Illuminate\Support\Facades\Storage;
use App\Models\InformasiFrontOffice;
use App\Http\Controllers\SendEmailController;
use Purifier;

class PengajuanKeberatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->sendemail = new SendEmailController;        
    }
   
    protected $title = "Pengajuan Keberatan Informasi Publik";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = StatusPermohonan::whereNull('deleted_at')->get();
        return view('back-office.pages.pengajuankeberatan_bo', ['title' => $this->title, 'status' => $status]);
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
        return view('front-office.pages.pengajuan_keberatan');
    }

    public function show_dataprogres()
    {
        return view('front-office.pages.progres_pengajuankeberatan');
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
            'nomor_pendaftaran' => 'required|unique:pengajuan_keberatan',
            'tujuan_penggunaaninformasi' => 'required',
            'alasan_keberatan' => 'required',
            'kasus_posisi' => 'required',
            'tanggal_ataskeberatan' => 'required',
        ];

        $messages = [
            'nomor_pendaftaran.required' => 'Field \':attribute\' tidak boleh kosong',
            'nomor_pendaftaran.unique' => 'Nomor pendaftaran tidak boleh sama, harus unique. Klik formulir untuk me-refresh nomor pendaftaran yang terbaru.',
            'tujuan_penggunaaninformasi.required' => 'Field \':attribute\' tidak boleh kosong',
            'alasan_keberatan.required' => 'Field \':attribute\' tidak boleh kosong',
            'kasus_posisi.required' => 'Field \':attribute\' tidak boleh kosong',
            'tanggal_ataskeberatan.required' => 'Field \':attribute\' tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages); 

        if(count($request->alasan_keberatan) > 0):
            $data_alasan_keberatan = $request->alasan_keberatan;
            $alasan_keberatan = implode("#",$data_alasan_keberatan);
        endif;  

        $status = 'Menunggu approval';
        // $keterangan = 'Menunggu admin memproses pengajuan';

        $data = array(
            'id_user' => $request->id_user,
            'nomor_pendaftaran' => $request->nomor_pendaftaran,
            'tujuan_penggunaaninformasi' => Purifier::clean($request->tujuan_penggunaaninformasi),
            'alasan_keberatan' => Purifier::clean($alasan_keberatan),
            'kasus_posisi' => Purifier::clean($request->kasus_posisi) ,
            'tanggal_ataskeberatan' => $request->tanggal_ataskeberatan,
            'status_permintaan' => $status,
            'keterangan' => NULL,
        );        

        $query = PengajuanKeberatan::create($data);
        $idInserted = $query->id;

        $datalog = array(
            'id_pengajuankeberatan' => $idInserted,
            'tanggal_activity' => Carbon::now(),
            'status' => $status,
            'action' => "new insert",
            'id_user' => auth()->user()->id,
            'alasan_penolakan' => NULL,
        );   

        $this->storeLogPengajuanKeberatan($datalog);
        $this->storeNomorPendaftaran($request->nomor_urut);      

        if($query):
            $sendnotif = $this->sendNotification($idInserted);
            Alert::toast('Data Pengajuan Keberatan Atas Informasi Berhasil Dikirim', 'success');
            return redirect()->route('pengajuan-keberatan');
        else:
            Alert::error('Gagal', 'Data Pengajuan Kebpengajuan-keberataninformasi-publik');
        endif;

    }

    private function storeLogPengajuanKeberatan($datalog)
    {
        $query = LogPengajuanKeberatan::create($datalog);
    } 

    public function getNoPendaftaran()
    {
        $formatNoPendaftaran = '/Req/PPID.02/'.Carbon::now()->format('m').'/'.Carbon::now()->year;
        
        $count = LogNomorPendaftaranPengajuanKeberatan::all()->count();
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
            $getLastNumber = LogNomorPendaftaranPengajuanKeberatan::get()->last();

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

        $query = LogNomorPendaftaranPengajuanKeberatan::create($dataset);
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
            return redirect()->route('pengajuan-keberatan-bo');            
        endif;

        if(! auth()->user()->hasAnyPermission(['confirm']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update status permohonan.', 'error');
            return redirect()->route('pengajuan-keberatan-bo');            
        endif;

        $status = $request->status_pengajuan_keberatan;
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
                    'status_permintaan' => $request->status_pengajuan_keberatan,
                    'alasan_penolakan' => $alasan,
                );                
            endif;
        endif;

        $query = PengajuanKeberatan::find($id)->update($data);

        $datalog = array(
            'id_pengajuankeberatan' => $id,
            'tanggal_activity' => Carbon::now(),
            'status' => $status,
            'action' => "update data",
            'id_user' => auth()->user()->id,
            'alasan_penolakan' => $alasan,
        );   

        $this->storeLogPengajuanKeberatan($datalog);        

        if($query):
            Alert::toast('Update Data Status Permintaan Berhasil', 'success');
            return redirect()->route('pengajuan-keberatan-bo');
        else:
            Alert::toast('Update Data Status Permintaan Gagal.!', 'error');
            return redirect()->route('pengajuan-keberatan-bo');
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
        $data = DB::table('pengajuan_keberatan')
            ->join('users', 'users.id', '=', 'pengajuan_keberatan.id_user')
            ->select([
                'users.name',
                'users.email',
                'pengajuan_keberatan.nomor_pendaftaran',
                'pengajuan_keberatan.id',
                'pengajuan_keberatan.tujuan_penggunaaninformasi',
                'pengajuan_keberatan.alasan_keberatan',
                'pengajuan_keberatan.kasus_posisi',
                'pengajuan_keberatan.tanggal_ataskeberatan',
                'pengajuan_keberatan.status_permintaan',
                'pengajuan_keberatan.alasan_penolakan',
                'pengajuan_keberatan.keterangan',
                'pengajuan_keberatan.created_at',
                'pengajuan_keberatan.updated_at'
            ])
            ->orderBy('pengajuan_keberatan.id', 'DESC')
            ->get();

        return DataTables::of($data)
            ->editColumn('created_at', function($data){ $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d-F-Y'); return $formatedDate; })
            ->editColumn('tanggal_ataskeberatan', function($data){ $tanggalAtaskeberatan = date("d/m/Y", strtotime($data->tanggal_ataskeberatan));; return $tanggalAtaskeberatan; })             
            ->addColumn('status_update', function($data){
                if(auth()->user()->hasPermissionTo('confirm')):
                    $statusupdated = "<button class='btn btn-primary' data-toggle='modal' data-target='#statusPengajuanKeberatanModal'>Action</button>";
                else:
                    $statusupdated = "<button class='btn disabled btn-primary' style='cursor:not-allowed'>Action</button>";
                endif;     
                return $statusupdated;           
            })
            ->addColumn('route_status_update', function($data){
                $route_status_update = route('pengajuan-keberatan-bo-editstatus', ['id' =>$data->id]);    
                return $route_status_update;           
            })  
            ->editColumn('alasan_keberatan_list', function($data){ 
                $raw1 = Str::remove('<p>', $data->alasan_keberatan);    
                $raw2 = Str::remove('</p>', $raw1);

                $checkString = strpos($raw2, "#");
                if($checkString):
                    $string = explode("#", $raw2);
                        $datateks = "";
                    foreach($string as $val):
                        $datateks .= "<li style='list-style-type:square'>".$val.",</li>";
                    endforeach;
                    $txt = $datateks;
                else:
                    $txt = "<li style='list-style-type:square'>".$raw2."</li>";
                endif;
                    return $txt;
            })  
            ->editColumn('alasan_keberatan', function($data){ 
                $raw1 = Str::remove('<p>', $data->alasan_keberatan);    
                $raw2 = Str::remove('</p>', $raw1); 

                $checkString = strpos($raw2, "#");
                if($checkString):
                    $string = explode("#", $raw2);
                        $datateks = array();
                    foreach($string as $val):
                        $datateks[] = $val;
                    endforeach;
                    $txt = $datateks;
                else:
                    $txt = $raw2;
                endif;
                    return $txt;
            })    
            ->addColumn('tujuan_penggunaaninformasi', function($data){
                $raw1 = Str::remove('<p>', $data->tujuan_penggunaaninformasi);    
                $raw2 = Str::remove('</p>', $raw1);    
                return $raw2;           
            }) 
            ->addColumn('kasus_posisi', function($data){
                $raw1 = Str::remove('<p>', $data->kasus_posisi);    
                $raw2 = Str::remove('</p>', $raw1);    
                return $raw2;           
            })                                           
            ->rawColumns(['status_update','route_status_update', 'alasan_keberatan_list','alasan_keberatan'])             
            ->toJson();;
    }

    public function getDatatablesJson_user()
    {
        $id_user = auth()->user()->id;
        $data = DB::table('pengajuan_keberatan')
            ->join('users', 'users.id', '=', 'pengajuan_keberatan.id_user')
            ->join('status_permohonan', 'status_permohonan.nama_status_singkat', '=', 'pengajuan_keberatan.status_permintaan')
            ->select([
                'users.name',
                'users.email',
                'status_permohonan.nama_status',
                'pengajuan_keberatan.nomor_pendaftaran',
                'pengajuan_keberatan.id',
                'pengajuan_keberatan.tujuan_penggunaaninformasi',
                'pengajuan_keberatan.alasan_keberatan',
                'pengajuan_keberatan.alasan_penolakan',
                'pengajuan_keberatan.kasus_posisi',
                'pengajuan_keberatan.tanggal_ataskeberatan',
                'pengajuan_keberatan.status_permintaan',
                'pengajuan_keberatan.keterangan',
                'pengajuan_keberatan.created_at',
                'pengajuan_keberatan.updated_at',
                'pengajuan_keberatan.click_survey',
                'pengajuan_keberatan.confirm_survey',
            ])
            ->where('pengajuan_keberatan.id_user', $id_user)
            ->orderBy('pengajuan_keberatan.id', 'DESC')
            ->get();

        return DataTables::of($data)
            ->editColumn('created_at', function($data){ $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d-F-Y'); return $formatedDate; })
            ->editColumn('alasan_keberatan', function($data){ 
                $raw1 = Str::remove('<p>', $data->alasan_keberatan);    
                $raw2 = Str::remove('</p>', $raw1); 

                $checkString = strpos($raw2, "#");
                if($checkString):
                    $string = explode("#", $raw2);
                        $datateks = "";
                    foreach($string as $val):
                        $datateks .= "<li style='list-style-type:square'>".$val.",</li>";
                    endforeach;
                    $txt = $datateks;
                else:
                    $txt = "<li style='list-style-type:square'>".$raw2."</li>";
                endif;
                    return $txt;
            })  
            ->addColumn('link_survey', function($data){
                $route_survey = $this->getLinkSurvey();
                $route_clicksurvey = route('pengajuan-keberatan-click-survey', ['id' =>$data->id]);
                $route_confirm = route('pengajuan-keberatan-confirm-survey', ['id' =>$data->id]);
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
            ->addColumn('tujuan_penggunaaninformasi', function($data){
                $raw1 = Str::remove('<p>', $data->tujuan_penggunaaninformasi);    
                $raw2 = Str::remove('</p>', $raw1);    
                return $raw2;           
            })              
            ->rawColumns(['alasan_keberatan', 'link_survey'])            
            ->toJson();;
    }

    public function sendNotification($id) 
    {
        $infoData = [
            'subject' => 'Notifikasi Pengajuan Keberatan Atas Permintaan Informasi',
            'name' => 'Pengajuan Keberatan Atas Permintaan Informasi',
            'body' => 'Anda mendapatkan notifikasi Pengajuan Keberatan Atas Permintaan Informasi',
            'thanks' => 'Terima Kasih',
            'text' => 'Data Detail',
            'url' => url('pengajuan-keberatan-informasi/email/'.$id),
            'id' => $id,
        ];

        // $email = env('MAIL_FROM_ADDRESS');
        // $email = config('mail.to.address');
        // Notification::route('mail', $email)->notify(new RequestPPIDNotification($infoData));
        // $email = env('MAIL_FROM_ADDRESS');
        // $emails = ['bukantika@gmail.com', 'h.wafi21@gmail.com', 'muharam.aram@support.bappenas.go.id'];
        
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
        $title = "Detail Data Pengajuan Keberatan";
        $result = PengajuanKeberatan::findOrFail($id);

        if(!empty($result)):
            $data = $result;
            $query = User::findOrFail($result['id_user']);
            $namapemohon = $query['name'];
        else:
            $data = NULL;
            $namapemohon = NULL;
        endif;

        return view('back-office.details.detail_email_pengajuankeberatan', ['title' => $title, 'data' => $data, 'nama' => $namapemohon]);        
    }

    public function clickLinkSurvey(Request $request, $id)
    {
        $data = array(
            'click_survey' => 1,
        );                

        $query = PengajuanKeberatan::find($id)->update($data);       

        if($query):
            return redirect()->away($this->getLinkSurvey());
        else:
            return redirect()->route('pengajuan-keberatan-progres');
        endif;        
    }

    public function confirmHasInputSurvey(Request $request, $id)
    {
        $data = array(
            'confirm_survey' => 1,
        );                

        $query = PengajuanKeberatan::find($id)->update($data);       

        if($query):
            Alert::toast('Terima kasih telah mengisi survey layanan dari kami', 'success');
            return redirect()->route('pengajuan-keberatan-progres');
        else:
            Alert::toast('Konfirmasi pengisian survey Gagal.!', 'error');
            return redirect()->route('pengajuan-keberatan-progres');
        endif;          
    }



}
