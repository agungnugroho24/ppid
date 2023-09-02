<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostKontenProfil;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class PostKontenProfilController extends Controller
{
    protected $title = "Pengolahan Konten Profil PPID";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back-office.pages.postkontenprofil_bo', ['title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back-office.forms.form_postkontenprofil_bo', ['title' => $this->title]);
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
            return redirect()->route('post-konten-profil-create');            
        endif;

        if(! auth()->user()->hasAnyPermission(['super-create', 'create']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan tambah data.', 'error');
            return redirect()->route('post-konten-profil-create');            
        endif;

        $rules = [
            'created_by' => 'required',
            'judul' => 'required',
            'menu' => 'required',
            'isi_konten' => 'required',
            'status_post' => 'required',
        ];

        $messages = [
            'judul.required' => 'Field \':attribute\' tidak boleh kosong',
            'menu.required' => 'Field \':attribute\' tidak boleh kosong',
            'isi_konten.required' => 'Field \':attribute\' tidak boleh kosong',
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

        // $dokumen = $request->file('dokumen');
        // $dok_name = $request->file('dokumen')->getClientOriginalName();
        // $dokumen->storeAs('public/dokumen_user', $dok_name);

        $data = array(
            'uuid_code' => Uuid::uuid4()->getHex()->toString(),
            'created_at' => Carbon::now(),
            'created_by' => $request->created_by,
            'judul' => $request->judul,
            'menu' => $request->menu,
            'isi_konten' => $request->isi_konten,
            'status_post' => $request->status_post,
            'is_publish' => $is_publish,
            'published_at' => $published_at,
        );

        $query = PostKontenProfil::create($data);

        if($query):
            Alert::toast('Tambah Data Konten Profil PPID Berhasil', 'success');
            return redirect()->route('post-konten-profil-create');
        else:
            Alert::toast('Tambah Data Konten Profil PPID Gagal.!', 'error');
            return redirect()->route('post-konten-profil-create');
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
        $post = PostKontenProfil::findOrFail($id);
        return view('back-office.forms.form_edit_postkontenprofil_bo', ['title' => $this->title, 'data' => $post]);
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
            return redirect()->route('post-konten-profil');            
        endif;

        if(! auth()->user()->hasAnyPermission(['super-update', 'update']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update data.', 'error');
            return redirect()->route('post-konten-profil');            
        endif;

        $rules = [
            'updated_by' => 'required',
            'judul' => 'required',
            'menu' => 'required',
            'isi_konten' => 'required',
        ];

        $messages = [
            'judul.required' => 'Field \':attribute\' tidak boleh kosong',
            'menu.required' => 'Field \':attribute\' tidak boleh kosong',
            'isi_konten.required' => 'Field \':attribute\' tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);
        
        $data = array(
            'updated_at' => Carbon::now(),
            'updated_by' => $request->updated_by,
            'judul' => $request->judul,
            'menu' => $request->menu,
            'isi_konten' => $request->isi_konten,
        );

        $query = PostKontenProfil::find($id)->update($data);

        if($query):
            Alert::toast('Update Data Konten Profil PPID Berhasil', 'success');
            return redirect()->route('post-konten-profil');
        else:
            Alert::toast('Update Data Konten Profil PPID Gagal.!', 'error');
            return redirect()->route('post-konten-profil');
        endif;              
    }

    public function updatestatuspost(Request $request, $id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan publish data.', 'error');
            return redirect()->route('post-konten-profil');            
        endif;

        if(! auth()->user()->hasAnyPermission(['publish']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan publish data.', 'error');
            return redirect()->route('post-konten-profil');             
        endif;         

        $result = PostKontenProfil::findOrFail($id);
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

        $query = PostKontenProfil::find($id)->update($data);       

        if($query):
            Alert::toast('Update Data Status Post Profil PPID Berhasil', 'success');
            return redirect()->route('post-konten-profil');
        else:
            Alert::toast('Update Data Status Post Profil PPID Gagal.!', 'error');
            return redirect()->route('post-konten-profil');
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
            return redirect()->route('post-konten-profil');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('post-konten-profil');            
        endif; 

        $postcontent = PostKontenProfil::find($id);
        $query = $postcontent->forceDelete();

        if($query):
            Alert::toast('Force Delete Data Konten Profil PPID Berhasil', 'success');
            return redirect()->route('post-konten-profil');
        else:
            Alert::toast('Force Delete Data Konten Profil PPID Gagal.!', 'error');
            return redirect()->route('post-konten-profil');
        endif;
    }

    public function softdelete($id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('post-konten-profil');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete', 'soft-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('post-konten-profil');            
        endif; 

        $deleted_by = auth()->user()->id;
        $data = array(
            'deleted_by' => $deleted_by,
        );

        $query = PostKontenProfil::find($id)->update($data);

        if($query):
            $postcontent = PostKontenProfil::find($id);
            $querydelete = $postcontent->delete();

            if($querydelete):
                Alert::toast('Soft Delete Data Konten Profil PPID Berhasil', 'success');
                return redirect()->route('post-konten-profil');
            endif;
        else:
                Alert::toast('Soft Delete Data Konten Profil PPID Gagal.!', 'error');
                return redirect()->route('post-konten-profil');
        endif;

    }

    public function getDatatablesJson()
    {
        $data = DB::table('post_konten_profil')
            ->join('users', 'users.id', '=', 'post_konten_profil.created_by')
            ->select([
                'post_konten_profil.id',
                'users.name',
                'post_konten_profil.judul',
                'post_konten_profil.menu',
                'post_konten_profil.isi_konten',
                'post_konten_profil.is_publish',
                'post_konten_profil.status_post',
                'post_konten_profil.published_at',
                'post_konten_profil.created_at',
                'post_konten_profil.created_by',
                'post_konten_profil.updated_at',
                'post_konten_profil.deleted_at'
            ])
            ->whereNull('post_konten_profil.deleted_at')
            ->orderBy('post_konten_profil.id', 'DESC')
            ->get();
        
        return DataTables::of($data)
            ->addColumn('update', function($data){
                $route_update = route('post-konten-profil-edit', ['id' =>$data->id]);
                if(auth()->user()->hasPermissionTo('super-update')):
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data'><i class='far fa-edit'></i></a>";
                else:
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data'><i class='far fa-edit'></i></a>";
                endif;     
                return $updated;           
            })
            ->addColumn('delete', function($data){
                $route_delete = route('post-konten-profil-delete', ['id' =>$data->id]);
                $route_softdelete = route('post-konten-profil-soft-delete', ['id' =>$data->id]);
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
                $route_publish = route('post-konten-profil-publish', ['id' =>$data->id]);
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
