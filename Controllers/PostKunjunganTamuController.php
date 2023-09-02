<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostContent;
use App\Models\PostKunjunganTamu;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Models\InformasiFrontOffice;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class PostKunjunganTamuController extends Controller
{
    public function __construct()
    {
        //        
    }

    protected $title = "Pengolahan Konten Kunjungan Tamu";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back-office.pages.postkunjungantamu_bo', ['title' => $this->title]);
    }

    public function sop()
    {
        $kategori = 'sop';
        $data = $this->getDataPostKunjunganTamu($kategori);  
        return view('front-office.pages.sop', ['data' => $data]);
    } 

    public function tatacara()
    {
        $kategori = 'tata cara';
        $data = $this->getDataPostKunjunganTamu($kategori);        
        return view('front-office.pages.tata_cara', ['data' => $data]);
    }    

    public function getDataPostKunjunganTamu($kategori)
    {
        $result = DB::table('post_kunjungan_tamu')->where('kategori', $kategori)->where('is_publish', '=', 1)->whereNull('deleted_at')->simplePaginate(5);

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
        return view('back-office.forms.form_postkunjungantamu_bo', ['title' => $this->title]);
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
            return redirect()->route('post-kunjungan-tamu-create');            
        endif;

        if(! auth()->user()->hasAnyPermission(['super-create', 'create']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan tambah data.', 'error');
            return redirect()->route('post-kunjungan-tamu-create');            
        endif;

        $rules = [
            'created_by' => 'required',
            'judul' => 'required',
            'kategori' => 'required',
            'isi_konten' => 'required',
            'konten_pendek' => 'required',
            'status_post' => 'required',
        ];

        $messages = [
            'judul.required' => 'Field \':attribute\' tidak boleh kosong',
            'kategori.required' => 'Field \':attribute\' tidak boleh kosong',
            'isi_konten.required' => 'Field \':attribute\' tidak boleh kosong',
            'konten_pendek.required' => 'Field \':attribute\' tidak boleh kosong',
            'status_post.required' => 'Field \':attribute\' tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);

        if($request->status_post == "publish"):
            $published_at = Carbon::now();
            $is_publish = TRUE;
            // $statuspost = $request->status_post;
        else:
            $published_at = NULL;
            $is_publish = FALSE;
            // $statuspost = $request->status_post;
        endif;

        // $dokumen = $request->file('dokumen');
        // $dok_name = $request->file('dokumen')->getClientOriginalName();
        // $dokumen->storeAs('public/dokumen_user', $dok_name);

        $data = array(
            'uuid_code' => Uuid::uuid4()->getHex()->toString(),
            'created_at' => Carbon::now(),
            'created_by' => $request->created_by,
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'isi_konten' => $request->isi_konten,
            'konten_pendek' => $request->konten_pendek,
            'status_post' => $request->status_post,
            'is_publish' => $is_publish,
            'published_at' => $published_at,
        );

        $query = PostKunjunganTamu::create($data);

        if($query):
            Alert::toast('Tambah Data Konten Kunjungan Tamu Berhasil', 'success');
            return redirect()->route('post-kunjungan-tamu-create');
        else:
            Alert::toast('Tambah Data Konten Kunjungan Tamu Gagal.!', 'error');
            return redirect()->route('post-kunjungan-tamu-create');
        endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $data = $this->getDataShowDetail($uuid);
        return view('front-office.details.page_detail_kunjungantamu', ['title' => $this->title, 'data' => $data]);
    }

    public function getDataShowDetail($uuid)
    {
        $query = PostKunjunganTamu::where('uuid_code',$uuid)->get();
        if($query->isNotEmpty()):
            foreach($query as $row):
                $judul = $row->judul;
                $isi_konten = $row->isi_konten;
                $konten_pendek = $row->konten_pendek;
                $tanggalpost = date("d F, Y", strtotime($row->created_at));
                $penulis = 'Admin';
                $kategori = $row->kategori;
            endforeach;

            if(! empty($kategori)):
                if($kategori == 'sop'):
                    $url = route('ppid-sop');
                elseif($kategori == 'tata cara'):
                    $url = route('ppid-tatacara');
                else:
                    $url = route('front-office');
                endif;
            else:
                    $url = route('front-office');
            endif;

            $data = [ 'judul' => $judul, 'isi_konten' => $isi_konten, 'konten_pendek' => $konten_pendek,
                'tanggalpost' => $tanggalpost, 'penulis' => $penulis, 'kategori' => $kategori, 'url' => $url,
            ]; 
        else:
            $data = null;
        endif;

        return $data;
    } 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = PostKunjunganTamu::findOrFail($id);
        return view('back-office.forms.form_edit_postkunjungantamu_bo', ['title' => $this->title, 'data' => $post]);
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
            return redirect()->route('post-kunjungan-tamu');            
        endif;

        if(! auth()->user()->hasAnyPermission(['super-update', 'update']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update data.', 'error');
            return redirect()->route('post-kunjungan-tamu');            
        endif;

        $rules = [
            'updated_by' => 'required',
            'judul' => 'required',
            'kategori' => 'required',
            'isi_konten' => 'required',
            'konten_pendek' => 'required',
        ];

        $messages = [
            'judul.required' => 'Field \':attribute\' tidak boleh kosong',
            'kategori.required' => 'Field \':attribute\' tidak boleh kosong',
            'isi_konten.required' => 'Field \':attribute\' tidak boleh kosong',
            'konten_pendek.required' => 'Field \':attribute\' tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);
        
        $data = array(
            'updated_at' => Carbon::now(),
            'updated_by' => $request->updated_by,
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'isi_konten' => $request->isi_konten,
            'konten_pendek' => $request->konten_pendek,
        );

        $query = PostKunjunganTamu::find($id)->update($data);

        if($query):
            Alert::toast('Update Data Konten Kunjungan Tamu Berhasil', 'success');
            return redirect()->route('post-kunjungan-tamu');
        else:
            Alert::toast('Update Data Konten Kunjungan Tamu Gagal.!', 'error');
            return redirect()->route('post-kunjungan-tamu');
        endif;              
    }


    public function updatestatuspost(Request $request, $id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan publish data.', 'error');
            return redirect()->route('post-kunjungan-tamu');            
        endif;

        if(! auth()->user()->hasAnyPermission(['publish']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan publish data.', 'error');
            return redirect()->route('post-kunjungan-tamu');            
        endif;         

        $result = PostKunjunganTamu::findOrFail($id);
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

        $query = PostKunjunganTamu::find($id)->update($data);       

        if($query):
            Alert::toast('Update Data Status Post Kunjungan Tamu Berhasil', 'success');
            return redirect()->route('post-kunjungan-tamu');
        else:
            Alert::toast('Update Data Status Post Kunjungan Tamu Gagal.!', 'error');
            return redirect()->route('post-kunjungan-tamu');
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
            return redirect()->route('post-kunjungan-tamu');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('post-kunjungan-tamu');            
        endif;  

        $postcontent = PostKunjunganTamu::find($id);
        $query = $postcontent->forceDelete();

        if($query):
            Alert::toast('Force Delete Data Konten Kunjungan Tamu Berhasil', 'success');
            return redirect()->route('post-kunjungan-tamu');
        else:
            Alert::toast('Force Delete Data Konten Kunjungan Tamu Gagal.!', 'error');
            return redirect()->route('post-kunjungan-tamu');
        endif;
    }

    public function softdelete($id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('post-kunjungan-tamu');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete', 'soft-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('post-kunjungan-tamu');            
        endif;         

        $deleted_by = auth()->user()->id;
        $data = array(
            'deleted_by' => $deleted_by,
        );

        $query = PostKunjunganTamu::find($id)->update($data);

        if($query):
            $postcontent = PostKunjunganTamu::find($id);
            $querydelete = $postcontent->delete();

            if($querydelete):
                Alert::toast('Soft Delete Data Konten Kunjungan Tamu Berhasil', 'success');
                return redirect()->route('post-kunjungan-tamu');
            endif;
        else:
                Alert::toast('Hapus Data Konten Kunjungan Tamu Gagal.!', 'error');
                return redirect()->route('post-kunjungan-tamu');
        endif;

    }    

    public function getDatatablesJson()
    {
        $data = DB::table('post_kunjungan_tamu')
            ->join('users', 'users.id', '=', 'post_kunjungan_tamu.created_by')
            ->select([
                'post_kunjungan_tamu.id',
                'users.name',
                'post_kunjungan_tamu.judul',
                'post_kunjungan_tamu.kategori',
                'post_kunjungan_tamu.isi_konten',
                'post_kunjungan_tamu.konten_pendek',
                'post_kunjungan_tamu.is_publish',
                'post_kunjungan_tamu.status_post',
                'post_kunjungan_tamu.published_at',
                'post_kunjungan_tamu.created_at',
                'post_kunjungan_tamu.created_by',
                'post_kunjungan_tamu.updated_at',
                'post_kunjungan_tamu.deleted_at'
            ])
            ->whereNull('post_kunjungan_tamu.deleted_at')
            ->orderBy('post_kunjungan_tamu.id', 'DESC')
            ->get();
        
        return DataTables::of($data)
            ->addColumn('update', function($data){
                $route_update = route('post-kunjungan-tamu-edit', ['id' =>$data->id]);
                if(auth()->user()->hasPermissionTo('super-update')):
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data'><i class='far fa-edit'></i></a>";
                else:
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data'><i class='far fa-edit'></i></a>";
                endif;     
                return $updated;           
            })
            ->addColumn('delete', function($data){
                $route_delete = route('post-kunjungan-tamu-delete', ['id' =>$data->id]);
                $route_softdelete = route('post-kunjungan-tamu-soft-delete', ['id' =>$data->id]);
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
                $route_publish = route('post-kunjungan-tamu-publish', ['id' =>$data->id]);
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
