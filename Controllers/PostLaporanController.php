<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostLaporan;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\InformasiFrontOffice;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class PostLaporanController extends Controller
{
    public function __construct()
    {
        //        
    }

    protected $title = "Pengolahan Konten Laporan";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back-office.pages.postlaporan_bo', ['title' => $this->title]);
    }

    public function aksesinfopublik()
    {
        $kategori = 'Akses Informasi Publik';
        $paginate = 5;
        $data = $this->getDataPostLaporan($kategori, $paginate);        
        return view('front-office.pages.akses_informasi_publik', ['data' => $data]);
    } 

    public function layananinfopublik()
    {
        $kategori = 'Layanan Informasi Publik';
        $paginate = 5;
        $data = $this->getDataPostLaporan($kategori, $paginate);         
        return view('front-office.pages.layanan_informasi_publik', ['data' => $data]);
    } 

    public function surveilayananinfopublik()
    {
        $kategori = 'Survey Layanan Informasi Publik';
        $paginate = 5;
        $data = $this->getDataPostLaporan($kategori, $paginate);        
        return view('front-office.pages.survei_layanan_informasi_publik', ['data' => $data]);
    } 

    public function statkunjungantamu()
    {
        $kategori = 'Statistik Kunjungan Tamu';
        $paginate = 5;
        $data = $this->getDataPostLaporan($kategori, $paginate); 
        return view('front-office.pages.statistik_kunjungan_tamu', ['data' => $data]);
    }     

    public function getDataPostLaporan($kategori, $paginate)
    {
        $result = DB::table('post_laporan')->where('kategori', $kategori)->where('is_publish', '=', 1)->whereNull('deleted_at')->orderBy('id', 'desc')->simplePaginate($paginate);

        if($result->isNotEmpty()):
            $data = $result;
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
        return view('back-office.forms.form_postlaporan_bo', ['title' => $this->title]);
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
            return redirect()->route('post-laporan-create');            
        endif;

        if(! auth()->user()->hasAnyPermission(['super-create', 'create']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan tambah data.', 'error');
            return redirect()->route('post-laporan-create');            
        endif;

        $rules = [
            'created_by' => 'required',
            'judul' => 'required',
            'kategori' => 'required',
            'isi_konten' => 'required',
            'cover_image' => 'required|mimes:jpg,jpeg|max:5100',
            'file' => 'required|mimes:pdf',
            'status_post' => 'required',
        ];

        $messages = [
            'judul.required' => 'Field \':attribute\' tidak boleh kosong',
            'kategori.required' => 'Field \':attribute\' tidak boleh kosong',
            'isi_konten.required' => 'Field \':attribute\' tidak boleh kosong',
            'cover_image.required' => 'Field \':attribute\' tidak boleh kosong',
            'cover_image.mimes' => 'Format file harus .jpg atau .jpeg',
            'cover_image.max' => 'Ukuran file maksimal 5Mb',
            'file.required' => 'Field \':attribute\' tidak boleh kosong',
            'file.mimes' => 'Format file harus .pdf',
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

        // $cover = $request->file('cover_image');
        // $original_filename = $request->namefile_cover_image;
        // $dok_name = $original_filename.'-'.date('d-F-Y').'-'.time().'.'.$cover->getClientOriginalExtension(); 
        // $cover->storeAs('public/post_laporan', $dok_name);

        if(!empty($request->file('cover_image'))):
            $fileupload_image = $request->file('cover_image'); 
            $original_filename_image = Str::replace(' ', '_', $request->namefile_cover_image);
            $dok_name_coverimage = $original_filename_image.'_'.date('d_F_Y_H_i_s').'.'.$fileupload_image->getClientOriginalExtension();            
            $fileupload_image->storeAs('public/post_laporan', $dok_name_coverimage);
        else:
            $dok_name_coverimage = NULL;
        endif;        

        if(!empty($request->file('file'))):
            $fileupload = $request->file('file');
            $original_filename = Str::replace(' ', '_', $request->namefile_format);
            $dok_name_datafile = $original_filename.'_'.date('d_F_Y_H_i_s').'.'.$fileupload->getClientOriginalExtension();            
            $fileupload->storeAs('public/post_laporan', $dok_name_datafile);
        else:
            $dok_name_datafile = NULL;
        endif;        

        $data = array(
            'uuid_code' => Uuid::uuid4()->getHex()->toString(),
            'created_at' => Carbon::now(),
            'created_by' => $request->created_by,
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'isi_konten' => $request->isi_konten,
            'data_file' => $dok_name_datafile,
            'cover_image' => $dok_name_coverimage,
            'status_post' => $request->status_post,
            'is_publish' => $is_publish,
            'published_at' => $published_at,
        );

        $query = PostLaporan::create($data);

        if($query):
            Alert::toast('Tambah Data Konten Laporan Berhasil', 'success');
            return redirect()->route('post-laporan-create');
        else:
            Alert::toast('Tambah Data Konten Laporan Gagal.!', 'error');
            return redirect()->route('post-laporan-create');
        endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showFileLaporan($uuid)
    {
        //
    }

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
        $post = PostLaporan::findOrFail($id);
        return view('back-office.forms.form_edit_postlaporan_bo', ['title' => $this->title, 'data' => $post]);
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
            return redirect()->route('post-laporan');            
        endif;

        if(! auth()->user()->hasAnyPermission(['super-update', 'update']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update data.', 'error');
            return redirect()->route('post-laporan');            
        endif;

        $rules = [
            'updated_by' => 'required',
            'judul' => 'required',
            'kategori' => 'required',
            'isi_konten' => 'required',
            'cover_image' => 'mimes:jpg,jpeg|max:5100',
            'file' => 'mimes:pdf',
        ];

        $messages = [
            'judul.required' => 'Field \':attribute\' tidak boleh kosong',
            'kategori.required' => 'Field \':attribute\' tidak boleh kosong',
            'isi_konten.required' => 'Field \':attribute\' tidak boleh kosong',
            // 'cover_image.required' => 'Field \':attribute\' tidak boleh kosong',
            'cover_image.mimes' => 'Format file harus .jpg atau .jpeg',
            'cover_image.max' => 'Ukuran file maksimal 5Mb',            
            'file.mimes' => 'Format file harus .pdf',
        ];

        $this->validate($request, $rules, $messages);


        if($request->cover_image == NULL || $request->cover_image == "" ):
            $dok_name_coverimage = $request->old_namefile_cover_image;
        else:
            $exist = Storage::exists('public/post_laporan/'.$request->old_namefile_cover_image);
            if($exist):
                $path_image = 'public/post_laporan/'.$request->old_namefile_cover_image;
                $res = Storage::delete($path_image);
            endif;

            $cover = $request->file('cover_image');
            $original_filename_image = Str::replace(' ', '_', $request->namefile_cover_image);
            $dok_name_coverimage = $original_filename_image.'_'.date('d_F_Y_H_i_s').'.'.$cover->getClientOriginalExtension();               
            $cover->storeAs('public/post_laporan', $dok_name_coverimage);
        endif;


        if($request->file('file') == NULL || $request->file('file') == "" ):
            $dok_name_datafile = $request->old_namefile_format;
        else:
            $exist = Storage::exists('public/post_laporan/'.$request->old_namefile_format);
            if($exist):
                $path = 'public/post_laporan/'.$request->old_namefile_format;
                $res = Storage::delete($path);
            endif;

            $fileupload = $request->file('file'); 
            $original_filename = Str::replace(' ', '_', $request->namefile_format);
            $dok_name_datafile = $original_filename.'_'.date('d_F_Y_H_i_s').'.'.$fileupload->getClientOriginalExtension();            
            $fileupload->storeAs('public/post_laporan', $dok_name_datafile);
        endif;        

        
        $data = array(
            'updated_at' => Carbon::now(),
            'updated_by' => $request->updated_by,
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'isi_konten' => $request->isi_konten,
            'cover_image' => $dok_name_coverimage,            
            'data_file' => $dok_name_datafile,            
        );

        $query = PostLaporan::find($id)->update($data);

        if($query):
            Alert::toast('Update Data Konten Laporan Berhasil', 'success');
            return redirect()->route('post-laporan');
        else:
            Alert::toast('Update Data Konten Laporan Gagal.!', 'error');
            return redirect()->route('post-laporan');
        endif;              
    }

    public function updatestatuspost(Request $request, $id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan publish data.', 'error');
            return redirect()->route('post-laporan');            
        endif;

        if(! auth()->user()->hasAnyPermission(['publish']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan publish data.', 'error');
            return redirect()->route('post-laporan');            
        endif;         

        $result = PostLaporan::findOrFail($id);
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

        $query = PostLaporan::find($id)->update($data);       

        if($query):
            Alert::toast('Update Data Status Post Laporan Berhasil', 'success');
            return redirect()->route('post-laporan');
        else:
            Alert::toast('Update Data Status Post Laporan Gagal.!', 'error');
            return redirect()->route('post-laporan');
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
        if(! auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('post-laporan');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('post-laporan');            
        endif;

        $postcontent = PostLaporan::find($id);

        $exist = Storage::exists('public/post_laporan/'.$postcontent->cover_image);
        if($exist):
            $path = 'public/post_laporan/'.$postcontent->cover_image;
            $res = Storage::delete($path);
        endif; 

        $exist_datafile = Storage::exists('public/post_laporan/'.$postcontent->data_file);
        if($exist_datafile):
            $path_datafile = 'public/post_laporan/'.$postcontent->data_file;
            $res_datafile = Storage::delete($path_datafile);
        endif;

        $query = $postcontent->forceDelete();

        if($query):
            Alert::toast('Force Delete Data Konten Laporan Berhasil', 'success');
            return redirect()->route('post-laporan');
        else:
            Alert::toast('Force Delete Data Konten Laporan Gagal.!', 'error');
            return redirect()->route('post-laporan');
        endif;
    }

    public function softdelete($id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('post-laporan');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete', 'soft-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('post-laporan');            
        endif; 

        $deleted_by = auth()->user()->id;
        $data = array(
            'deleted_by' => $deleted_by,
        );

        $query = PostLaporan::find($id)->update($data);

        if($query):
            $postcontent = PostLaporan::find($id);
            $querydelete = $postcontent->delete();

            if($querydelete):
                Alert::toast('Soft Delete Data Konten Laporan Berhasil', 'success');
                return redirect()->route('post-laporan');
            endif;
        else:
                Alert::toast('Hapus Data Konten Laporan Gagal.!', 'error');
                return redirect()->route('post-laporan');
        endif;

    } 

    public function getDatatablesJson()
    {
        $data = DB::table('post_laporan')
            ->join('users', 'users.id', '=', 'post_laporan.created_by')
            ->select([
                'post_laporan.id',
                'users.name',
                'post_laporan.judul',
                'post_laporan.kategori',
                'post_laporan.isi_konten',
                'post_laporan.cover_image',
                'post_laporan.is_publish',
                'post_laporan.status_post',
                'post_laporan.published_at',
                'post_laporan.created_at',
                'post_laporan.created_by',
                'post_laporan.updated_at',
                'post_laporan.deleted_at'
            ])
            ->whereNull('post_laporan.deleted_at')
            ->orderBy('post_laporan.id', 'DESC')
            ->get();
        
        return DataTables::of($data)
            ->addColumn('update', function($data){
                $route_update = route('post-laporan-edit', ['id' =>$data->id]);
                if(auth()->user()->hasPermissionTo('super-update')):
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data'><i class='far fa-edit'></i></a>";
                else:
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data'><i class='far fa-edit'></i></a>";
                endif;     
                return $updated;           
            })
            ->addColumn('delete', function($data){
                $route_delete = route('post-laporan-delete', ['id' =>$data->id]);
                $route_softdelete = route('post-laporan-soft-delete', ['id' =>$data->id]);
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
                $route_publish = route('post-laporan-publish', ['id' =>$data->id]);
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
            ->addColumn('isi_konten', function($data){
                $konten = $data->isi_konten;   
                return $konten;            
            })                      
            ->rawColumns(['update', 'delete', 'publish', 'isi_konten'])
            ->toJson();
        // return DataTables::of($data)
        //     ->addColumn('update', $updated)
        //     ->addColumn('delete', $deleted)
        //     ->rawColumns(['update', 'delete'])
        //     ->toJson();

    }

}
