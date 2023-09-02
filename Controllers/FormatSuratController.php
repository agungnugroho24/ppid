<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormatSurat;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FormatSuratController extends Controller
{
    protected $title = "Pengolahan Format Surat Permohonan Kunjungan";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back-office.pages.formatsurat_bo', ['title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back-office.forms.form_formatsurat_bo', ['title' => $this->title]);
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
            return redirect()->route('format-surat-adm-create');            
        endif;

        if(! auth()->user()->hasAnyPermission(['super-create']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan tambah data.', 'error');
            return redirect()->route('format-surat-adm-create');            
        endif;

        $rules = [
            'created_by' => 'required',
            'judul' => 'required',
            'file' => 'required|mimes:docx|max:5100',
            'status_post' => 'required',
        ];

        $messages = [
            'judul.required' => 'Field \':attribute\' tidak boleh kosong',
            'file.required' => 'Field \':attribute\' tidak boleh kosong',
            'file.mimes' => 'Format file harus .docx',
            'file.max' => 'Ukuran file maksimal 5Mb',
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



        $fileupload = $request->file('file');
        // $original_filename = $request->namefile_format;
        // $dok_name = $original_filename.'-'.date('d-F-Y H-i-s').'.'.$fileupload->getClientOriginalExtension(); 
        $original_filename = Str::replace(' ', '_', $request->namefile_format);
        $dok_name = $original_filename.'_'.date('d_F_Y_H_i_s').'.'.$fileupload->getClientOriginalExtension();
        $fileupload->storeAs('public/template_surat_kunjungan', $dok_name);

        $data = array(
            'created_at' => Carbon::now(),
            'created_by' => $request->created_by,
            'judul' => $request->judul,
            'file' => $dok_name,
            'status_post' => $request->status_post,
            'is_publish' => $is_publish,
            'published_at' => $published_at,
        );

        $query = FormatSurat::create($data);

        if($query):
            Alert::toast('Tambah Data Format Surat Berhasil', 'success');
            return redirect()->route('format-surat-adm-create');
        else:
            Alert::toast('Tambah Data Format Surat Gagal.!', 'error');
            return redirect()->route('format-surat-adm-create');
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
        $post = FormatSurat::findOrFail($id);
        return view('back-office.forms.form_edit_formatsurat_bo', ['title' => $this->title, 'data' => $post]);
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
            return redirect()->route('format-surat-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['super-update']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update data.', 'error');
            return redirect()->route('format-surat-adm');            
        endif;

        $rules = [
            'updated_by' => 'required',
            'judul' => 'required',
            'file' => 'mimes:docx|max:5100',
        ];

        $messages = [
            'judul.required' => 'Field \':attribute\' tidak boleh kosong',
            'file.mimes' => 'Format file harus .docx',
            'file.max' => 'Ukuran file maksimal 5Mb',
        ];        

        $this->validate($request, $rules, $messages);

        if($request->file('file') == NULL || $request->file('file') == "" ):
            $dok_name = $request->old_namefile_format;
        else:
            $exist = Storage::exists('public/template_surat_kunjungan/'.$request->old_namefile_format);
            if($exist):
                $path = 'public/template_surat_kunjungan/'.$request->old_namefile_format;
                $res = Storage::delete($path);
            endif;

            $fileupload = $request->file('file');
            // $original_filename = $request->namefile_format;
            // $dok_name = $original_filename.'-'.date('d-F-Y H-i-s').'.'.$fileupload->getClientOriginalExtension();
            $original_filename = Str::replace(' ', '_', $request->namefile_format);
            $dok_name = $original_filename.'_'.date('d_F_Y_H_i_s').'.'.$fileupload->getClientOriginalExtension();
            $fileupload->storeAs('public/template_surat_kunjungan', $dok_name);
        endif;
        
        $data = array(
            'updated_at' => Carbon::now(),
            'updated_by' => $request->updated_by,
            'judul' => $request->judul,
            'file' => $dok_name,
        );

        $query = FormatSurat::find($id)->update($data);

        if($query):
            Alert::toast('Update Data Format Surat Berhasil', 'success');
            return redirect()->route('format-surat-adm');
        else:
            Alert::toast('Update Data Format Surat Gagal.!', 'error');
            return redirect()->route('format-surat-adm');
        endif;              
    }

    public function updatestatuspost(Request $request, $id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan publish data.', 'error');
            return redirect()->route('format-surat-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['publish']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan publish data.', 'error');
            return redirect()->route('format-surat-adm');            
        endif;        

        $result = FormatSurat::findOrFail($id);
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

        $query = FormatSurat::find($id)->update($data);       

        if($query):
            Alert::toast('Update Data Status Format Surat Berhasil', 'success');
            return redirect()->route('format-surat-adm');
        else:
            Alert::toast('Update Data Status Format Surat Gagal.!', 'error');
            return redirect()->route('format-surat-adm');
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
            return redirect()->route('format-surat-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('format-surat-adm');            
        endif; 

        $postcontent = FormatSurat::find($id);

        $exist = Storage::exists('public/template_surat_kunjungan/'.$postcontent->file);
        if($exist):
            $path = 'public/template_surat_kunjungan/'.$postcontent->file;
            $res = Storage::delete($path);
        endif; 

        $query = $postcontent->forceDelete();

        if($query):
            Alert::toast('Force Delete Data Format Surat Berhasil', 'success');
            return redirect()->route('format-surat-adm');
        else:
            Alert::toast('Force Delete Data Format Surat Gagal.!', 'error');
            return redirect()->route('format-surat-adm');
        endif;
    }

    public function softdelete($id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('format-surat-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('format-surat-adm');            
        endif; 

        $deleted_by = auth()->user()->id;
        $data = array(
            'deleted_by' => $deleted_by,
        );

        $query = FormatSurat::find($id)->update($data);

        if($query):
            $postcontent = FormatSurat::find($id);
            $querydelete = $postcontent->delete();

            if($querydelete):
                Alert::toast('Soft Delete Data Format Surat Berhasil', 'success');
                return redirect()->route('format-surat-adm');
            endif;
        else:
                Alert::toast('Soft Delete Data Konten Format Surat Gagal.!', 'error');
                return redirect()->route('format-surat-adm');
        endif;

    }    

    public function getDatatablesJson()
    {
        $data = DB::table('format_surat')
            ->join('users', 'users.id', '=', 'format_surat.created_by')
            ->select([
                'format_surat.id',
                'users.name',
                'format_surat.judul',
                'format_surat.file',
                'format_surat.is_publish',
                'format_surat.status_post',
                'format_surat.published_at',
                'format_surat.created_at',
                'format_surat.created_by',
                'format_surat.updated_at',
                'format_surat.deleted_at'
            ])
            ->whereNull('format_surat.deleted_at')
            ->orderBy('format_surat.id', 'DESC')
            ->get();
        
        return DataTables::of($data)
            ->addColumn('update', function($data){
                $route_update = route('format-surat-adm-edit', ['id' =>$data->id]);
                if(auth()->user()->hasPermissionTo('super-update')):
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data'><i class='far fa-edit'></i></a>";
                else:
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data'><i class='far fa-edit'></i></a>";
                endif;     
                return $updated;           
            })
            ->addColumn('delete', function($data){
                $route_delete = route('format-surat-adm-delete', ['id' =>$data->id]);
                $route_softdelete = route('format-surat-adm-soft-delete', ['id' =>$data->id]);
                if(auth()->user()->hasPermissionTo('soft-delete')):
                    $deleted = "<a href='$route_softdelete' class='btn btn-icon btn-sm btn-danger soft-delete-confirm' title='Soft Delete'><i class='far fa-trash-alt'></i></a>";
                elseif(auth()->user()->hasPermissionTo('hard-delete')):
                    $soft_deleted = "<a href='$route_softdelete' class='btn btn-icon btn-sm btn-danger soft-delete-confirm' title='Soft Delete'><i class='far fa-trash-alt'></i></a>";

                    $hard_deleted = "<a href='$route_delete' class='btn btn-icon btn-sm btn-custom-2 hard-delete-confirm' title='Hard Delete'><i class='fas fa-eraser'></i></a>";

                    $deleted = $soft_deleted.' &#9474; '.$hard_deleted;
                else:
                    $deleted = "<button class='btn btn-icon btn-sm btn-danger disabled' title='Delete' style='cursor:not-allowed'><i class='far fa-trash-alt'></i></button>";
                endif;    
                return $deleted;            
            })
            ->addColumn('publish', function($data){
                $route_publish = route('format-surat-adm-publish', ['id' =>$data->id]);
                if(auth()->user()->hasPermissionTo('publish')):
                    if($data->is_publish == 0):
                        $published = "<a href='$route_publish' class='btn btn-icon btn-sm btn-custom-1' title='Published'><i class='fas fa-share-square'></i></a>";
                    else:
                        $published = "<a href='$route_publish' class='btn btn-icon btn-sm btn-custom-3' title='Unpublished'><i class='fas fa-share-square'></i></a>";
                    endif;
                else:
                    $published = "<button class='btn btn-icon btn-sm btn-secondary disabled' title='Pubish Content'><i class='fas fa-share-square' style='cursor:not-allowed'></i></button>";
                endif;    
                return $published;            
            })           
            ->rawColumns(['update', 'delete', 'publish'])
            ->toJson();

    }


}
