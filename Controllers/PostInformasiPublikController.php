<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostInformasiPublik;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Models\InformasiFrontOffice;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class PostInformasiPublikController extends Controller
{
    public function __construct()
    {
        //        
    }

    protected $title = "Pengolahan Konten Informasi Publik";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back-office.pages.postinformasipublik_bo', ['title' => $this->title]);
    } 

    public function testpage()
    {
        return view('front-office.details.page_detail', ['title' => $this->title]);
    }

    public function informasiberkala()
    {
        $kategori = 'Berkala';
        $data = $this->getDataPostInformasiPublik($kategori);   
        return view('front-office.pages.informasi_berkala', ['data' => $data]);
    }   
    
    public function informasisertamerta()
    {
        $kategori = 'Serta Merta';
        $data = $this->getDataPostInformasiPublik($kategori);        
        return view('front-office.pages.informasi_sertamerta', ['data' => $data]);
    } 

    public function informasisetiapsaat()
    {
        $kategori = 'Setiap Saat';
        $data = $this->getDataPostInformasiPublik($kategori);        
        return view('front-office.pages.informasi_setiapsaat', ['data' => $data]);
    }    

    public function getDataPostInformasiPublik($kategori)
    {
        $result = DB::table('post_informasi_publik')->where('kategori', $kategori)->where('is_publish', '=', 1)->whereNull('deleted_at')->simplePaginate(5);
        
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
        return view('back-office.forms.form_postinformasipublik_bo', ['title' => $this->title]);
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
            return redirect()->route('post-informasi-publik-create');            
        endif;

        if(! auth()->user()->hasAnyPermission(['super-create', 'create']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan tambah data.', 'error');
            return redirect()->route('post-informasi-publik-create');            
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

        $query = PostInformasiPublik::create($data);

        if($query):
            Alert::toast('Tambah Data Konten Informasi Publik Berhasil', 'success');
            return redirect()->route('post-informasi-publik-create');
        else:
            Alert::toast('Tambah Data Konten Informasi Publik Gagal.!', 'error');
            return redirect()->route('post-informasi-publik-create');
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
        return view('front-office.details.page_detail_informasipublik', ['title' => $this->title, 'data' => $data]);
    }

    public function getDataShowDetail($uuid)
    {
        $query = PostInformasiPublik::where('uuid_code',$uuid)->get();
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
                if($kategori == 'Berkala'):
                    $url = route('ppid-informasiberkala');
                elseif($kategori == 'Serta Merta'):
                    $url = route('ppid-informasisertamerta');
                elseif($kategori == 'Setiap Saat'):
                    $url = route('ppid-informasisetiapsaat');
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
        $post = PostInformasiPublik::findOrFail($id);
        return view('back-office.forms.form_edit_postinformasipublik_bo', ['title' => $this->title, 'data' => $post]);
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
            return redirect()->route('post-informasi-publik');            
        endif;

        if(! auth()->user()->hasAnyPermission(['super-update', 'update']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update data.', 'error');
            return redirect()->route('post-informasi-publik');            
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

        $query = PostInformasiPublik::find($id)->update($data);

        if($query):
            Alert::toast('Update Data Konten Informasi Publik Berhasil', 'success');
            return redirect()->route('post-informasi-publik');
        else:
            Alert::toast('Update Data Konten Informasi Publik Gagal.!', 'error');
            return redirect()->route('post-informasi-publik');
        endif;              
    }

    public function updatestatuspost(Request $request, $id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan publish data.', 'error');
            return redirect()->route('post-informasi-publik');            
        endif;

        if(! auth()->user()->hasAnyPermission(['publish']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan publish data.', 'error');
            return redirect()->route('post-informasi-publik');            
        endif;         

        $result = PostInformasiPublik::findOrFail($id);
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

        $query = PostInformasiPublik::find($id)->update($data);       

        if($query):
            Alert::toast('Update Data Status Post Informasi Publik Berhasil', 'success');
            return redirect()->route('post-informasi-publik');
        else:
            Alert::toast('Update Data Status Post Informasi Publik Gagal.!', 'error');
            return redirect()->route('post-informasi-publik');
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
            return redirect()->route('post-informasi-publik');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('post-informasi-publik');            
        endif; 

        $postcontent = PostInformasiPublik::find($id);
        $query = $postcontent->forceDelete();

        if($query):
            Alert::toast('Force Delete Data Konten Informasi Publik Berhasil', 'success');
            return redirect()->route('post-informasi-publik');
        else:
            Alert::toast('Force Delete Data Konten Informasi Publik Gagal.!', 'error');
            return redirect()->route('post-informasi-publik');
        endif;
    }

    public function softdelete($id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer', 'sekretariat'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('post-informasi-publik');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete', 'soft-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('post-informasi-publik');            
        endif;

        $deleted_by = auth()->user()->id;
        $data = array(
            'deleted_by' => $deleted_by,
        );

        $query = PostInformasiPublik::find($id)->update($data);

        if($query):
            $postcontent = PostInformasiPublik::find($id);
            $querydelete = $postcontent->delete();

            if($querydelete):
                Alert::toast('Soft Delete Data Konten Informasi Publik Berhasil', 'success');
                return redirect()->route('post-informasi-publik');
            endif;
        else:
                Alert::toast('Soft Delete Data Konten Informasi Publik Gagal.!', 'error');
                return redirect()->route('post-informasi-publik');
        endif;

    }    

    public function getDatatablesJson()
    {
        $data = DB::table('post_informasi_publik')
            ->join('users', 'users.id', '=', 'post_informasi_publik.created_by')
            ->select([
                'post_informasi_publik.id',
                'users.name',
                'post_informasi_publik.judul',
                'post_informasi_publik.kategori',
                'post_informasi_publik.isi_konten',
                'post_informasi_publik.konten_pendek',
                'post_informasi_publik.is_publish',
                'post_informasi_publik.status_post',
                'post_informasi_publik.published_at',
                'post_informasi_publik.created_at',
                'post_informasi_publik.created_by',
                'post_informasi_publik.updated_at',
                'post_informasi_publik.deleted_at'
            ])
            ->whereNull('post_informasi_publik.deleted_at')
            ->orderBy('post_informasi_publik.id', 'DESC')
            ->get();
        
        return DataTables::of($data)
            ->addColumn('update', function($data){
                $route_update = route('post-informasi-publik-edit', ['id' =>$data->id]);
                if(auth()->user()->hasPermissionTo('super-update')):
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data' data-toggle='tooltip'><i class='far fa-edit'></i></a>";
                else:
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data' data-toggle='tooltip'><i class='far fa-edit'></i></a>";
                endif;     
                return $updated;           
            })
            ->addColumn('delete', function($data){
                $route_delete = route('post-informasi-publik-delete', ['id' =>$data->id]);
                $route_softdelete = route('post-informasi-publik-soft-delete', ['id' =>$data->id]);
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
                $route_publish = route('post-informasi-publik-publish', ['id' =>$data->id]);
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
            ->addColumn('isi_konten', function($data){
                $konten = $data->isi_konten;   
                return $konten;            
            })          
            ->rawColumns(['update', 'delete', 'publish', 'isi_konten'])
            ->toJson();
    }
}
