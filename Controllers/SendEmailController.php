<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SendEmail;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Notification;
use Illuminate\Support\Facades\Storage;

class SendEmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }  

    protected $title = "Pengolahan Penerima Email Notifikasi";  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $status = StatusPermohonan::whereNull('deleted_at')->get();
        return view('back-office.pages.sendemail_bo', ['title' => $this->title]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back-office.forms.form_kirimemail_bo', ['title' => $this->title]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan tambah data.', 'error');
            return redirect()->route('kirim-email-adm-create');            
        endif;

        if(! auth()->user()->hasAnyPermission(['super-create']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan tambah data.', 'error');
            return redirect()->route('kirim-email-adm-create');            
        endif;

        $rules = [
            'created_by' => 'required',
            'nama_penerima' => 'required',
            'email' => 'required',
            'status_kirim_email' => 'required',
        ];

        $messages = [
            'nama_penerima.required' => 'Field \':attribute\' tidak boleh kosong',
            'email.required' => 'Field \':attribute\' tidak boleh kosong',
            'status_kirim_email.required' => 'Field \':attribute\' tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);

        if($request->status_kirim_email == "active"):
            $is_active = TRUE;
        else:
            $is_active = FALSE;
        endif;

        $data = array(
            'created_at' => Carbon::now(),
            'created_by' => $request->created_by,
            'nama_penerima' => $request->nama_penerima,
            'email' => $request->email,
            'is_active' => $is_active,
        );

        $query = SendEmail::create($data);

        if($query):
            Alert::toast('Tambah Data Penerima Email Notifikasi Berhasil', 'success');
            return redirect()->route('kirim-email-adm-create');
        else:
            Alert::toast('Tambah Data Penerima Email Notifikasi Gagal.!', 'error');
            return redirect()->route('kirim-email-adm-create');
        endif;
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
        $post = SendEmail::findOrFail($id);
        return view('back-office.forms.form_edit_kirimemail_bo', ['title' => $this->title, 'data' => $post]);
    }

    public function getDataKirimNotifikasiEmail()
    {
        $emails = SendEmail::where('is_active', '=', 1)->whereNull('deleted_at')->get();

        if(count($emails) > 0):
            foreach($emails as $dataemail):
                $email[] = $dataemail->email;
            endforeach;
            $data = $email;
        else:
            $data = NULL;
        endif;

        return $data;
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
        if(! auth()->user()->hasRole(['super-administrator', 'developer'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update data.', 'error');
            return redirect()->route('kirim-email-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['super-update']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update data.', 'error');
            return redirect()->route('kirim-email-adm');            
        endif;

        $rules = [
            'updated_by' => 'required',
            'nama_penerima' => 'required',
            'email' => 'required',
        ];

        $messages = [
            'nama_penerima.required' => 'Field \':attribute\' tidak boleh kosong',
            'email.required' => 'Field \':attribute\' tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);
        
        $data = array(
            'updated_at' => Carbon::now(),
            'updated_by' => $request->updated_by,
            'nama_penerima' => $request->nama_penerima,
            'email' => $request->email,
        );

        $query = SendEmail::find($id)->update($data);

        if($query):
            Alert::toast('Update Data Penerima Email Notifikasi Berhasil', 'success');
            return redirect()->route('kirim-email-adm');
        else:
            Alert::toast('Update Data Penerima Email Notifikasi Gagal.!', 'error');
            return redirect()->route('kirim-email-adm');
        endif;              
    }

    public function updatestatuskirimemail(Request $request, $id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update status penerima email notifikasi.', 'error');
            return redirect()->route('kirim-email-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['publish']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update status penerima email notifikasi.', 'error');
            return redirect()->route('kirim-email-adm');            
        endif;        

        $result = SendEmail::findOrFail($id);
        if(!empty($result)):
            $active = $result->is_active;

            if($active == 0):
                $dataactive = 1;
            else:
                $dataactive = 0;             
            endif;
        endif; 

        $data = array(
            'is_active' => $dataactive,
        );          

        $query = SendEmail::find($id)->update($data);       

        if($query):
            Alert::toast('Update Status Penerima Email Notifikasi Berhasil', 'success');
            return redirect()->route('kirim-email-adm');
        else:
            Alert::toast('Update Status Penerima Email Notifikasi Gagal.!', 'error');
            return redirect()->route('kirim-email-adm');
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
        if(! auth()->user()->hasRole(['super-administrator', 'developer'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('kirim-email-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('kirim-email-adm');            
        endif; 

        $postcontent = SendEmail::find($id);
        $query = $postcontent->forceDelete();

        if($query):
            Alert::toast('Force Delete Data Penerima Email Notifikasi Berhasil', 'success');
            return redirect()->route('kirim-email-adm');
        else:
            Alert::toast('Force Delete Data Penerima Email Notifikasi Gagal.!', 'error');
            return redirect()->route('kirim-email-adm');
        endif;
    }

    public function softdelete($id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('kirim-email-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('kirim-email-adm');            
        endif;  

        $deleted_by = auth()->user()->id;
        $data = array(
            'deleted_by' => $deleted_by,
        );

        $query = SendEmail::find($id)->update($data);

        if($query):
            $postcontent = SendEmail::find($id);
            $querydelete = $postcontent->delete();

            if($querydelete):
                Alert::toast('Soft Delete Data Penerima Email Notifikasi Berhasil', 'success');
                return redirect()->route('kirim-email-adm');
            endif;
        else:
                Alert::toast('Hapus Data Penerima Email Notifikasi Gagal.!', 'error');
                return redirect()->route('kirim-email-adm');
        endif;

    } 

    public function getDatatablesJson()
    {
        $data = DB::table('send_mail')
            ->orderBy('id', 'DESC')
            ->whereNull('deleted_at')
            ->get();

        return DataTables::of($data)
            ->addColumn('update', function($data){
                $route_update = route('kirim-email-adm-edit', ['id' =>$data->id]);
                if(auth()->user()->hasPermissionTo('super-update')):
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data' data-toggle='tooltip'><i class='far fa-edit'></i></a>";
                else:
                    $updated = "<button class='btn btn-icon btn-sm btn-warning disabled' title='Update Data not-allowed' style='cursor:not-allowed' data-toggle='tooltip'><i class='far fa-edit'></i></button>";
                endif;     
                return $updated;           
            })
            ->addColumn('delete', function($data){
                $route_delete = route('kirim-email-adm-delete', ['id' =>$data->id]);
                $route_softdelete = route('kirim-email-adm-soft-delete', ['id' =>$data->id]);
                if(auth()->user()->hasPermissionTo('soft-delete')):
                    $deleted = "<a href='$route_softdelete' class='btn btn-icon btn-sm btn-danger soft-delete-confirm' title='Soft Delete' data-toggle='tooltip'><i class='far fa-trash-alt'></i></a>";
                elseif(auth()->user()->hasPermissionTo('hard-delete')):
                    $soft_deleted = "<a href='$route_softdelete' class='btn btn-icon btn-sm btn-danger soft-delete-confirm' title='Soft Delete' data-toggle='tooltip'><i class='far fa-trash-alt'></i></a>";

                    $hard_deleted = "<a href='$route_delete' class='btn btn-icon btn-sm btn-custom-2 hard-delete-confirm' title='Hard Delete' data-toggle='tooltip'><i class='fas fa-eraser'></i></a>";

                    $deleted = $soft_deleted.' &#9474; '.$hard_deleted;
                else:
                    $deleted = "<button class='btn btn-icon btn-sm btn-danger disabled' title='Delete not-allowed' style='cursor:not-allowed' data-toggle='tooltip'><i class='far fa-trash-alt'></i></button>";
                endif;    
                return $deleted;            
            })
            ->addColumn('active', function($data){
                $route_active = route('kirim-email-adm-publish', ['id' =>$data->id]);
                if(auth()->user()->hasPermissionTo('publish')):
                    if($data->is_active == 0):
                        $published = "<a href='$route_active' class='btn btn-icon btn-sm btn-custom-1' title='Active' data-toggle='tooltip'><i class='fas fa-share-square'></i></a>";
                    else:
                        $published = "<a href='$route_active' class='btn btn-icon btn-sm btn-custom-3' title='Deactive' data-toggle='tooltip'><i class='fas fa-share-square'></i></a>";
                    endif;
                else:
                    $published = "<button class='btn btn-icon btn-sm btn-secondary disabled' title='not-allowed' data-toggle='tooltip'><i class='fas fa-share-square' style='cursor:not-allowed'></i></button>";
                endif;    
                return $published;            
            })           
            ->rawColumns(['update', 'delete', 'active'])            
            ->toJson();
    }


}
