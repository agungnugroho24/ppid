<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InformasiFrontOffice;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class InformasiFrontOfficeController extends Controller
{
    protected $title = "Pengolahan Konten Informasi Front Office";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back-office.pages.informasifrontoffice_bo', ['title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back-office.forms.form_informasifrontoffice_bo', ['title' => $this->title]);
    }

    public function noLinkSurvey()
    {
        return view('front-office.pages.no_link_survey', ['title' => 'No Link Survey']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan tambah data.', 'error');
            return redirect()->route('informasi-front-office-adm-create');            
        endif;

        if(! auth()->user()->hasPermissionTo('super-create')):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan tambah data.', 'error');
            return redirect()->route('informasi-front-office-adm-create');            
        endif;

        $rules = [
            'created_by' => 'required',
            'nama' => 'required',
            'kategori' => 'required',
            'data' => 'required',
            'file' => 'mimes:jpg,jpeg,png',
            'status_post' => 'required',
        ];

        $messages = [
            'nama.required' => 'Field \':attribute\' tidak boleh kosong',
            'kategori.required' => 'Field \':attribute\' tidak boleh kosong',
            'data.required' => 'Field \':attribute\' tidak boleh kosong',
            // 'file.required' => 'Field \':attribute\' tidak boleh kosong',
            'file.mimes' => 'Format file harus .jpg, .jpeg, atau .png',
            'status_post.required' => 'Field \':attribute\' tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);

        if($request->status_post == "publish"):
            $published_at = Carbon::now();
            $is_publish = TRUE;
        else:
            $published_at = NULL;
            $is_publish = FALSE;
        endif;

        if(!empty($request->file('file'))):
            $fileupload = $request->file('file');
            // $original_filename = $request->namefile_format;
            // $dok_name = $original_filename.'-'.date('d-F-Y H-i-s').'.'.$fileupload->getClientOriginalExtension(); 
            $original_filename = Str::replace(' ', '_', $request->namefile_format);
            $dok_name = $original_filename.'_'.date('d_F_Y_H_i_s').'.'.$fileupload->getClientOriginalExtension();            
            $fileupload->storeAs('public/file_upload', $dok_name);
        else:
            $dok_name = NULL;
        endif;

        $data = array(
            'created_at' => Carbon::now(),
            'created_by' => $request->created_by,
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'data' => $request->data,
            'file' => $dok_name,
            'status_post' => $request->status_post,
            'is_publish' => $is_publish,
            'published_at' => $published_at,
        );

        $query = InformasiFrontOffice::create($data);

        if($query):
            Alert::toast('Tambah Data Konten Informasi Front Office Berhasil', 'success');
            return redirect()->route('informasi-front-office-adm-create');
        else:
            Alert::toast('Tambah Data Konten Informasi Front Office Gagal.!', 'error');
            return redirect()->route('informasi-front-office-adm-create');
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
        $post = InformasiFrontOffice::findOrFail($id);
        return view('back-office.forms.form_edit_informasifrontoffice_bo', ['title' => $this->title, 'data' => $post]);
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
        if(! auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update data.', 'error');
            return redirect()->route('informasi-front-office-adm');            
        endif;

        if(! auth()->user()->hasPermissionTo('super-update')):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update data.', 'error');
            return redirect()->route('informasi-front-office-adm');            
        endif;

        $rules = [
            'updated_by' => 'required',
            'nama' => 'required',
            'kategori' => 'required',
            'data' => 'required',
            'file' => 'mimes:jpg,jpeg,png',
        ];

        $messages = [
            'nama.required' => 'Field \':attribute\' tidak boleh kosong',
            'kategori.required' => 'Field \':attribute\' tidak boleh kosong',
            'data.required' => 'Field \':attribute\' tidak boleh kosong',
            // 'file.required' => 'Field \':attribute\' tidak boleh kosong',
            'file.mimes' => 'Format file harus .jpg, .jpeg, atau .png',
        ];

        $this->validate($request, $rules, $messages);
        
        if($request->file('file') == NULL || $request->file('file') == "" ):
            $dok_name = $request->old_namefile_format;
        else:
            $exist = Storage::exists('public/file_upload/'.$request->old_namefile_format);
            if($exist):
                $path = 'public/file_upload/'.$request->old_namefile_format;
                $res = Storage::delete($path);
            endif;

            $fileupload = $request->file('file'); 
            $original_filename = Str::replace(' ', '_', $request->namefile_format);
            $dok_name = $original_filename.'_'.date('d_F_Y_H_i_s').'.'.$fileupload->getClientOriginalExtension();            
            $fileupload->storeAs('public/file_upload', $dok_name);
        endif;

        $data = array(
            'updated_at' => Carbon::now(),
            'updated_by' => $request->updated_by,
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'data' => $request->data,
            'file' => $dok_name,
        );

        $query = InformasiFrontOffice::find($id)->update($data);

        if($query):
            Alert::toast('Update Data Konten Informasi Front Office Berhasil', 'success');
            return redirect()->route('informasi-front-office-adm');
        else:
            Alert::toast('Update Data Konten Informasi Front Office Gagal.!', 'error');
            return redirect()->route('informasi-front-office-adm');
        endif;              
    }

    public function updatestatuspost(Request $request, $id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan publish data.', 'error');
            return redirect()->route('informasi-front-office-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['publish']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan publish data.', 'error');
            return redirect()->route('informasi-front-office-adm');            
        endif;         

        $result = InformasiFrontOffice::findOrFail($id);
        if(!empty($result)):
            $publish = $result->is_publish;

            if($publish == 0):
                $datapublish = 1;
                $datastatus = "publish";
                $datapublished_at = Carbon::now();               
            else:
                $datapublish = 0;
                $datastatus = "pending";
                $datapublished_at = $result->published_at;               
            endif;
        endif; 

        $data = array(
            'is_publish' => $datapublish,
            'status_post' => $datastatus,
            'published_at' => $datapublished_at,
        );          

        $query = InformasiFrontOffice::find($id)->update($data);       

        if($query):
            Alert::toast('Update Data Status Post Informasi Front Office Berhasil', 'success');
            return redirect()->route('informasi-front-office-adm');
        else:
            Alert::toast('Update Data Status Post Informasi Front Office Gagal.!', 'error');
            return redirect()->route('informasi-front-office-adm');
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
            return redirect()->route('informasi-front-office-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('informasi-front-office-adm');            
        endif;        

        $postcontent = InformasiFrontOffice::find($id);

        $exist = Storage::exists('public/file_upload/'.$postcontent->file);
        if($exist):
            $path = 'public/file_upload/'.$postcontent->file;
            $res = Storage::delete($path);
        endif; 

        $query = $postcontent->forceDelete();

        if($query):
            Alert::toast('Force Delete Data Konten Informasi Front Office Berhasil', 'success');
            return redirect()->route('informasi-front-office-adm');
        else:
            Alert::toast('Force Delete Data Konten Informasi Front Office Gagal.!', 'error');
            return redirect()->route('informasi-front-office-adm');
        endif;
    }

    public function softdelete($id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('informasi-front-office-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete', 'soft-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('informasi-front-office-adm');            
        endif;         

        $deleted_by = auth()->user()->id;
        $data = array(
            'deleted_by' => $deleted_by,
        );

        $query = InformasiFrontOffice::find($id)->update($data);

        if($query):
            $postcontent = InformasiFrontOffice::find($id);
            $querydelete = $postcontent->delete();

            if($querydelete):
                Alert::toast('Soft Delete Data Konten Informasi Front Office Berhasil', 'success');
                return redirect()->route('informasi-front-office-adm');
            endif;
        else:
                Alert::toast('Hapus Data Konten Informasi Front Office Gagal.!', 'error');
                return redirect()->route('informasi-front-office-adm');
        endif;

    }    

    public function getDatatablesJson()
    {
        $data = DB::table('informasi_front_office')
            ->join('users', 'users.id', '=', 'informasi_front_office.created_by')
            ->select([
                'informasi_front_office.id',
                'users.name',
                'informasi_front_office.nama',
                'informasi_front_office.kategori',
                'informasi_front_office.data',
                'informasi_front_office.file',
                'informasi_front_office.is_publish',
                'informasi_front_office.status_post',
                'informasi_front_office.published_at',
                'informasi_front_office.created_at',
                'informasi_front_office.created_by',
                'informasi_front_office.updated_at',
                'informasi_front_office.deleted_at'
            ])
            ->whereNull('informasi_front_office.deleted_at')
            ->orderBy('informasi_front_office.id', 'DESC')
            ->get();
        
        return DataTables::of($data)
            ->addColumn('update', function($data){
                $route_update = route('informasi-front-office-adm-edit', ['id' =>$data->id]);
                if(auth()->user()->hasPermissionTo('super-update')):
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data' data-toggle='tooltip'><i class='far fa-edit'></i></a>";
                else:
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data' data-toggle='tooltip'><i class='far fa-edit'></i></a>";
                endif;     
                return $updated;           
            })
            ->addColumn('delete', function($data){
                $route_delete = route('informasi-front-office-adm-delete', ['id' =>$data->id]);
                $route_softdelete = route('informasi-front-office-adm-soft-delete', ['id' =>$data->id]);
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
            ->addColumn('publish', function($data){
                $route_publish = route('informasi-front-office-adm-publish', ['id' =>$data->id]);
                if(auth()->user()->hasPermissionTo('publish')):
                    if($data->is_publish == 0):
                        $published = "<a href='$route_publish' class='btn btn-icon btn-sm btn-custom-1' title='Published' data-toggle='tooltip'><i class='fas fa-share-square'></i></a>";
                    else:
                        $published = "<a href='$route_publish' class='btn btn-icon btn-sm btn-custom-3' title='Unpublished' data-toggle='tooltip'><i class='fas fa-share-square'></i></a>";
                    endif;
                else:
                    $published = "<button class='btn btn-icon btn-sm btn-secondary disabled' title='Publish Content not-allowed' data-toggle='tooltip'><i class='fas fa-share-square' style='cursor:not-allowed'></i></button>";
                endif;    
                return $published;            
            })            
            ->rawColumns(['update', 'delete', 'publish', 'data'])
            ->toJson();

    }

    public function getDataSosialMedia()
    {
        $result = InformasiFrontOffice::where('kategori', '=', 'Sosial Media')->where('is_publish', '=', 1)->whereNull('deleted_at')->get();

        if($result->isNotEmpty()):
            $sosmed = $result;
        else:
            $sosmed = NULL;
        endif;        

        return $sosmed;
    }   

    public function getDataKontak()
    {
        $result = InformasiFrontOffice::where('kategori', '=', 'Kontak')->where('is_publish', '=', 1)->whereNull('deleted_at')->get();

        if($result->isNotEmpty()):
            $kontak = $result;
        else:
            $kontak = NULL;
        endif;        

        return $kontak;
    }     

    public function getDataAlurInformasi()
    {
        $result = InformasiFrontOffice::where('kategori', '=', 'Informasi Permohonan')->where('is_publish', '=', 1)->whereNull('deleted_at')->get();

        if($result->isNotEmpty()):
            $data = $result;
        else:
            $data = NULL;
        endif;        

        return $data;        
    }
}
