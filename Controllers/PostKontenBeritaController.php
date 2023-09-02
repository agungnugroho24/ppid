<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostKontenBerita;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;


class PostKontenBeritaController extends Controller
{
    protected $title = "Pengolahan Konten Berita";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back-office.pages.postkontenberita_bo', ['title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back-office.forms.form_postkontenberita_bo', ['title' => $this->title]);
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
            return redirect()->route('post-konten-berita-create');            
        endif;

        if(! auth()->user()->hasAnyPermission(['super-create', 'create']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan tambah data.', 'error');
            return redirect()->route('post-konten-berita-create');            
        endif;

        $rules = [
            'created_by' => 'required',
            'judul' => 'required',
            'file' => 'mimes:jpg,jpeg,png',
            'isi_konten' => 'required',
            'konten_pendek' => 'required',
            'status_post' => 'required',
        ];

        $messages = [
            'judul.required' => 'Field \':attribute\' tidak boleh kosong',
            // 'kategori.required' => 'Field \':attribute\' tidak boleh kosong',
            'isi_konten.required' => 'Field \':attribute\' tidak boleh kosong',
            'konten_pendek.required' => 'Field \':attribute\' tidak boleh kosong',
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
            $original_filename = Str::replace(' ', '_', $request->namefile_format);
            $dok_name = $original_filename.'_'.date('d_F_Y_H_i_s').'.'.$fileupload->getClientOriginalExtension();            
            $fileupload->storeAs('public/post_berita', $dok_name);
        else:
            $dok_name = NULL;
        endif;



        $data = array(
            'uuid_code' => Uuid::uuid4()->getHex()->toString(),
            'created_at' => Carbon::now(),
            'created_by' => $request->created_by,
            'judul' => $request->judul,
            'isi_konten' => $request->isi_konten,
            'konten_pendek' => $request->konten_pendek,
            'thumbnail' => $dok_name,
            'status_post' => $request->status_post,
            'is_publish' => $is_publish,
            'published_at' => $published_at,
        );

        $query = PostKontenBerita::create($data);

        if($query):
            Alert::toast('Tambah Data Konten Berita Berhasil', 'success');
            return redirect()->route('post-konten-berita-create');
        else:
            Alert::toast('Tambah Data Konten Berita Gagal.!', 'error');
            return redirect()->route('post-konten-berita-create');
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
        $post = PostKontenBerita::findOrFail($id);
        return view('back-office.forms.form_edit_postkontenberita_bo', ['title' => $this->title, 'data' => $post]);
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
            return redirect()->route('post-konten-berita');            
        endif;

        if(! auth()->user()->hasAnyPermission(['super-update', 'update']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update data.', 'error');
            return redirect()->route('post-konten-berita');            
        endif;

        $rules = [
            'updated_by' => 'required',
            'judul' => 'required',
            'isi_konten' => 'required',
            'konten_pendek' => 'required',
            'file' => 'mimes:jpg,jpeg,png',
        ];

        $messages = [
            'judul.required' => 'Field \':attribute\' tidak boleh kosong',
            'isi_konten.required' => 'Field \':attribute\' tidak boleh kosong',
            'konten_pendek.required' => 'Field \':attribute\' tidak boleh kosong',
            'file.mimes' => 'Format file harus .jpg, .jpeg, atau .png',
        ];

        $this->validate($request, $rules, $messages);

        if($request->file('file') == NULL || $request->file('file') == "" ):
            $dok_name = $request->old_namefile_format;
        else:
            $exist = Storage::exists('public/post_berita/'.$request->old_namefile_format);
            if($exist):
                $path = 'public/post_berita/'.$request->old_namefile_format;
                $res = Storage::delete($path);
            endif;

            $fileupload = $request->file('file'); 
            $original_filename = Str::replace(' ', '_', $request->namefile_format);
            $dok_name = $original_filename.'_'.date('d_F_Y_H_i_s').'.'.$fileupload->getClientOriginalExtension();            
            $fileupload->storeAs('public/post_berita', $dok_name);
        endif;   

        $data = array(
            'updated_at' => Carbon::now(),
            'updated_by' => $request->updated_by,
            'judul' => $request->judul,
            'isi_konten' => $request->isi_konten,
            'konten_pendek' => $request->konten_pendek,
            'thumbnail' => $dok_name,
        );

        $query = PostKontenBerita::find($id)->update($data);

        if($query):
            Alert::toast('Update Data Konten Berita Berhasil', 'success');
            return redirect()->route('post-konten-berita');
        else:
            Alert::toast('Update Data Konten Berita Gagal.!', 'error');
            return redirect()->route('post-konten-berita');
        endif;              
    }

    public function updatestatuspost(Request $request, $id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan publish data.', 'error');
            return redirect()->route('post-konten-berita');            
        endif;

        if(! auth()->user()->hasAnyPermission(['publish']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan publish data.', 'error');
            return redirect()->route('post-konten-berita');            
        endif;         

        $result = PostKontenBerita::findOrFail($id);
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

        $query = PostKontenBerita::find($id)->update($data);       

        if($query):
            Alert::toast('Update Data Status Post Konten Berita Berhasil', 'success');
            return redirect()->route('post-konten-berita');
        else:
            Alert::toast('Update Data Status Post Konten Berita Gagal.!', 'error');
            return redirect()->route('post-konten-berita');
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
            return redirect()->route('post-konten-berita');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('post-konten-berita');            
        endif; 

        $postcontent = PostKontenBerita::find($id);

        $exist = Storage::exists('public/post_berita/'.$postcontent->thumbnail);
        if($exist):
            $path = 'public/post_berita/'.$postcontent->thumbnail;
            $res = Storage::delete($path);
        endif; 

        $query = $postcontent->forceDelete();

        if($query):
            Alert::toast('Force Delete Data Konten Berita Berhasil', 'success');
            return redirect()->route('post-konten-berita');
        else:
            Alert::toast('Force Delete Data Konten Berita Gagal.!', 'error');
            return redirect()->route('post-konten-berita');
        endif;
    }

    public function softdelete($id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('post-konten-berita');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete', 'soft-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('post-konten-berita');            
        endif; 

        $deleted_by = auth()->user()->id;
        $data = array(
            'deleted_by' => $deleted_by,
        );

        $query = PostKontenBerita::find($id)->update($data);

        if($query):
            $postcontent = PostKontenBerita::find($id);
            $querydelete = $postcontent->delete();

            if($querydelete):
                Alert::toast('Soft Delete Data Konten Berita Berhasil', 'success');
                return redirect()->route('post-konten-berita');
            endif;
        else:
                Alert::toast('Soft Delete Data Konten Berita Gagal.!', 'error');
                return redirect()->route('post-konten-berita');
        endif;

    }    

    public function getDatatablesJson()
    {
        $data = DB::table('post_konten_berita')
            ->join('users', 'users.id', '=', 'post_konten_berita.created_by')
            ->select([
                'post_konten_berita.id',
                'users.name',
                'post_konten_berita.judul',
                'post_konten_berita.kategori',
                'post_konten_berita.isi_konten',
                'post_konten_berita.is_publish',
                'post_konten_berita.status_post',
                'post_konten_berita.published_at',
                'post_konten_berita.created_at',
                'post_konten_berita.created_by',
                'post_konten_berita.updated_at',
                'post_konten_berita.deleted_at'
            ])
            ->whereNull('post_konten_berita.deleted_at')
            ->orderBy('post_konten_berita.id', 'DESC')
            ->get();
        
        return DataTables::of($data)
            ->addColumn('update', function($data){
                $route_update = route('post-konten-berita-edit', ['id' =>$data->id]);
                if(auth()->user()->hasPermissionTo('super-update')):
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data'><i class='far fa-edit'></i></a>";
                else:
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data'><i class='far fa-edit'></i></a>";
                endif;     
                return $updated;           
            })
            ->addColumn('delete', function($data){
                $route_delete = route('post-konten-berita-delete', ['id' =>$data->id]);
                $route_softdelete = route('post-konten-berita-soft-delete', ['id' =>$data->id]);
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
                $route_publish = route('post-konten-berita-publish', ['id' =>$data->id]);
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

    }


}
