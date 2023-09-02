<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostContent;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PostContentController extends Controller
{
    protected $title = "Pengolahan Konten";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back-office.pages.postcontent_bo', ['title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back-office.forms.form_postcontent_bo', ['title' => $this->title]);
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
            'created_by' => 'required',
            'judul' => 'required',
            'kategori' => 'required',
            'konten' => 'required',
            'status_post' => 'required',
            'jenis_post' => 'required'
        ];

        $messages = [
            'judul.required' => 'Field \':attribute\' tidak boleh kosong',
            'kategori.required' => 'Field \':attribute\' tidak boleh kosong',
            'konten.required' => 'Field \':attribute\' tidak boleh kosong',
            'status_post.required' => 'Field \':attribute\' tidak boleh kosong',
            'jenis_post.required' => 'Field \':attribute\' tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);

        if($request->status_post == "publish"):
            $published_at = date("Y-m-d H:i:s");
        else:
            $published_at = null;
        endif;

        // $dokumen = $request->file('dokumen');
        // $dok_name = $request->file('dokumen')->getClientOriginalName();
        // $dokumen->storeAs('public/dokumen_user', $dok_name);

        $data = array(
            'created_by' => $request->created_by,
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'konten' => $request->konten,
            'status_post' => $request->status_post,
            'jenis_post' => $request->jenis_post,
            'published_at' => $published_at,
        );

        $query = PostContent::create($data);

        if($query):
            Alert::toast('Tambah Data Konten Berhasil', 'success');
            return redirect()->route('post-content-create');
        else:
            Alert::toast('Tambah Data Konten Gagal.!', 'error');
            return redirect()->route('post-content-create');
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
        $post = PostContent::findOrFail($id);

        return view('back-office.forms.form_edit_postcontent_bo', ['title' => $this->title, 'data' => $post]);
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
        $rules = [
            'updated_by' => 'required',
            'judul' => 'required',
            'kategori' => 'required',
            'konten' => 'required',
            'status_post' => 'required',
            'jenis_post' => 'required'
        ];

        $messages = [
            'judul.required' => 'Field \':attribute\' tidak boleh kosong',
            'kategori.required' => 'Field \':attribute\' tidak boleh kosong',
            'konten.required' => 'Field \':attribute\' tidak boleh kosong',
            'status_post.required' => 'Field \':attribute\' tidak boleh kosong',
            'jenis_post.required' => 'Field \':attribute\' tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);

        if($request->status_post == "publish"):
            $published_at = date("Y-m-d H:i:s");
        else:
            $published_at = null;
        endif;  
        
        $data = array(
            'updated_by' => $request->updated_by,
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'konten' => $request->konten,
            'status_post' => $request->status_post,
            'jenis_post' => $request->jenis_post,
            'published_at' => $published_at,
        );

        $query = PostContent::find($id)->update($data);

        if($query):
            Alert::toast('Update Data Konten Berhasil', 'success');
            return redirect()->route('post-content-edit', $id);
        else:
            Alert::toast('Update Data Konten Gagal.!', 'error');
            return redirect()->route('post-content-edit', $id);
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
        $postcontent = PostContent::find($id);
        $query = $postcontent->forceDelete();

        if($query):
            Alert::toast('Force Delete Data Konten Berhasil', 'success');
            return redirect()->route('post-content');
        else:
            Alert::toast('Force Delete Data Konten Gagal.!', 'error');
            return redirect()->route('post-content');
        endif;
    }

    public function softdelete($id)
    {
        $deleted_by = auth()->user()->id;
        $data = array(
            'deleted_by' => $deleted_by,
        );

        $query = PostContent::find($id)->update($data);

        if($query):
            $postcontent = PostContent::find($id);
            $querydelete = $postcontent->delete();

            if($querydelete):
                Alert::toast('Soft Delete Data Konten Berhasil', 'success');
                return redirect()->route('post-content');
            endif;
        else:
                Alert::toast('Hapus Data Konten Gagal.!', 'error');
                return redirect()->route('post-content');
        endif;

    }    

    public function getDatatablesJson()
    {
        $data = DB::table('post_content')
            ->join('users', 'users.id', '=', 'post_content.created_by')
            ->select([
                'post_content.id',
                'users.name',
                'post_content.judul',
                'post_content.kategori',
                'post_content.konten',
                'post_content.status_post',
                'post_content.jenis_post',
                'post_content.created_at',
                'post_content.published_at',
                'post_content.updated_at',
                'post_content.deleted_at'
            ])->whereNull('deleted_at')->get();
        
        return DataTables::of($data)
            ->addColumn('update', function($data){
                $route_update = route('post-content-edit', ['id' =>$data->id]);
                if(auth()->user()->hasPermissionTo('super-update')):
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data'><i class='far fa-edit'></i></a>";
                else:
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data'><i class='far fa-edit'></i></a>";
                endif;     
                return $updated;           
            })
            ->addColumn('delete', function($data){
                $route_delete = route('post-content-delete', ['id' =>$data->id]);
                $route_softdelete = route('post-content-soft-delete', ['id' =>$data->id]);
                if(auth()->user()->hasPermissionTo('soft-delete')):
                    $deleted = "<a href='$route_softdelete' class='btn btn-icon btn-sm btn-dark' title='Soft Delete'><i class='far fa-trash-alt'></i></a>";
                else:
                    $deleted = "<a href='$route_delete' class='btn btn-icon btn-sm btn-danger' title='Hard Delete'><i class='fas fa-eraser'></i></a>";
                endif;    
                return $deleted;            
            })
            ->addColumn('publish', function($data){
                $route_delete = route('post-content-delete', ['id' =>$data->id]);
                if(auth()->user()->hasPermissionTo('soft-delete')):
                    $published = "<a href='$route_delete' class='btn btn-icon btn-sm btn-info' title='Pubish Content'><i class='far fa-trash-alt'></i></a>";
                else:
                    $published = "<a href='$route_delete' class='btn btn-icon btn-sm btn-info' title='Pubish Content'><i class='far fa-trash-alt'></i></a>";
                endif;    
                return $published;            
            })            
            ->rawColumns(['update', 'delete', 'publish'])
            ->toJson();
        // return DataTables::of($data)
        //     ->addColumn('update', $updated)
        //     ->addColumn('delete', $deleted)
        //     ->rawColumns(['update', 'delete'])
        //     ->toJson();

    }

}
