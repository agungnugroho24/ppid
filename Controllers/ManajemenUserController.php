<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostInformasiPublik;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Models\InformasiFrontOffice;

class ManajemenUserController extends Controller
{
    public function __construct()
    {
        //        
    }  

    protected $title = "Pengolahan User Aplikasi PPID";  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back-office.pages.manajemen_user_bo', ['title' => $this->title]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function changeactivationuser(Request $request, $id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan aktivasi user.', 'error');
            return redirect()->route('manajemen-user-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['assign']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan aktivasi user.', 'error');
            return redirect()->route('manajemen-user-adm');            
        endif; 

        $result = User::findOrFail($id);
        if(!empty($result)):
            $activate = $result->is_active;

            if($activate == 0):
                $data_status = 1;
            else:
                $data_status = 0;
            endif;
        endif; 

        $data = array(
            'is_active' => $data_status,
        );          

        $query = User::find($id)->update($data);       

        if($query):
            Alert::toast('Update Data Status User Berhasil', 'success');
            return redirect()->route('manajemen-user-adm');
        else:
            Alert::toast('Update Data Status User Gagal.!', 'error');
            return redirect()->route('manajemen-user-adm');
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
            return redirect()->route('manajemen-user-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('manajemen-user-adm');            
        endif;

        $post = User::find($id);
        if($post->is_active == 1):
            Alert::toast('Data Tidak Dapat Dihapus, User Masih Aktif.!', 'warning');
            return redirect()->route('manajemen-user-adm');  
        else:
            $query = $post->forceDelete();

            if($query):
                Alert::toast('Force Delete Data User Berhasil', 'success');
                return redirect()->route('manajemen-user-adm');
            else:
                Alert::toast('Force Delete Data User Gagal.!', 'error');
                return redirect()->route('manajemen-user-adm');
            endif;          
        endif;
    }

    public function softdelete($id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('manajemen-user-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('manajemen-user-adm');            
        endif;

        $post = User::find($id);
        if($post->is_active == 1):
            Alert::toast('Data Tidak Dapat Dihapus, User Masih Aktif.!', 'warning');
            return redirect()->route('manajemen-user-adm');             
        else:
            $deleted_by = auth()->user()->id;
            $data = array(
                'deleted_by' => $deleted_by,
            );
            $query = User::find($id)->update($data);

            if($query):
                $post = User::find($id);
                $querydelete = $post->delete();

                if($querydelete):
                    Alert::toast('Soft Delete Data User Berhasil', 'success');
                    return redirect()->route('manajemen-user-adm');
                endif;
            else:
                    Alert::toast('Soft Delete Data User Gagal.!', 'error');
                    return redirect()->route('manajemen-user-adm');
            endif;
        endif;

    }  

    public function getDatatablesJson()
    {
        $data = DB::table('users')
            ->select(
                'id',
                'name',
                'first_name',
                'last_name',
                'jenis_pemohon',
                'user_name',
                'email',
                'jenis_identitas',
                'nomor_identitas',
                'nomor_ponsel',
                'keterangan',
                'is_active',
                'created_at',
                'updated_at',
            )
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->get();
        
        return DataTables::of($data)    
            ->addColumn('activate', function($data){
                $route_activate = route('manajemen-user-adm-activation', ['id' =>$data->id]);
                if(auth()->user()->hasPermissionTo('assign')):
                    $activate = "<a href='$route_activate' class='btn btn-icon btn-sm btn-info' title='Change Status User' data-toggle='tooltip'><i class='fas fa-sync'></i></a>";
                else:
                    $activate = "<button class='btn btn-icon btn-sm btn-secondary disabled' title='Change Status User not-allowed' data-toggle='tooltip'><i class='fas fa-sync' style='cursor:not-allowed'></i></button>";
                endif;     
                return $activate;           
            })
            ->addColumn('delete', function($data){
                $route_delete = route('manajemen-user-adm-delete', ['id' =>$data->id]);
                $route_softdelete = route('manajemen-user-adm-soft-delete', ['id' =>$data->id]);
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
            ->rawColumns(['activate', 'delete'])
            ->toJson();
    }    
}
