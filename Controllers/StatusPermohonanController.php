<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatusPermohonan;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class StatusPermohonanController extends Controller
{
    protected $title = "Pengolahan Status Permohonan";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back-office.pages.statuspermohonan_bo', ['title' => $this->title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back-office.forms.form_statuspermohonan_bo', ['title' => $this->title]);
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
            'nama_status' => 'required',
            'nama_status_singkat' => 'required',
        ];

        $messages = [
            'nama_status.required' => 'Field \':attribute\' tidak boleh kosong',
            'nama_status_singkat.required' => 'Field \':attribute\' tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);

        $data = array(
            'nama_status' => $request->nama_status,
            'nama_status_singkat' => $request->nama_status_singkat,
            'created_at' => Carbon::now(),
        );

        $query = StatusPermohonan::create($data);

        if($query):
            Alert::toast('Tambah Data Status Permohonan Berhasil', 'success');
            return redirect()->route('status-permohonan-adm-create');
        else:
            Alert::toast('Tambah Data Status Permohonan Gagal.!', 'error');
            return redirect()->route('status-permohonan-adm-create');
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
        $post = StatusPermohonan::findOrFail($id);
        return view('back-office.forms.form_edit_statuspermohonan_bo', ['title' => $this->title, 'data' => $post]);
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
            return redirect()->route('status-permohonan-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['super-update']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update data.', 'error');
            return redirect()->route('status-permohonan-adm');            
        endif;

        $rules = [
            'nama_status' => 'required',
            'nama_status_singkat' => 'required',
        ];

        $messages = [
            'nama_status.required' => 'Field \':attribute\' tidak boleh kosong',
            'nama_status_singkat.required' => 'Field \':attribute\' tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages); 
        
        $data = array(
            'nama_status' => $request->nama_status,
            'nama_status_singkat' => $request->nama_status_singkat,
            'updated_at' => Carbon::now(),
        );

        $query = StatusPermohonan::find($id)->update($data);

        if($query):
            Alert::toast('Update Data Status Permohonan Berhasil', 'success');
            return redirect()->route('status-permohonan-adm');
        else:
            Alert::toast('Update Data Status Permohonan Gagal.!', 'error');
            return redirect()->route('status-permohonan-adm');
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
            return redirect()->route('status-permohonan-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('status-permohonan-adm');            
        endif;

        $post = StatusPermohonan::find($id);
        $query = $post->forceDelete();

        if($query):
            Alert::toast('Force Delete Data Status Permohonan Berhasil', 'success');
            return redirect()->route('status-permohonan-adm');
        else:
            Alert::toast('Force Delete Data Status Permohonan Gagal.!', 'error');
            return redirect()->route('status-permohonan-adm');
        endif;
    }

    public function softdelete($id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('status-permohonan-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['hard-delete']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan hapus data.', 'error');
            return redirect()->route('status-permohonan-adm');            
        endif;

        $post = StatusPermohonan::find($id);
        $querydelete = $post->delete();

        if($querydelete):
            Alert::toast('Soft Delete Data Status Permohonan Berhasil', 'success');
            return redirect()->route('status-permohonan-adm');
        else:
            Alert::toast('Hapus Data Status Permohonan Gagal.!', 'error');
            return redirect()->route('status-permohonan-adm');
        endif;

    }

    public function getDatatablesJson()
    {
        $data = DB::table('status_permohonan')
            ->select([
                'status_permohonan.id',
                'status_permohonan.nama_status',
                'status_permohonan.nama_status_singkat',
                'status_permohonan.created_at',
                'status_permohonan.updated_at',
                'status_permohonan.deleted_at'
            ])
            ->whereNull('deleted_at')
            ->get();
        
        return DataTables::of($data)
            ->addColumn('update', function($data){
                $route_update = route('status-permohonan-adm-edit', ['id' =>$data->id]);
                if(auth()->user()->hasPermissionTo('super-update')):
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data'><i class='far fa-edit'></i></a>";
                else:
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data'><i class='far fa-edit'></i></a>";
                endif;     
                return $updated;           
            })
            ->addColumn('delete', function($data){
                $route_delete = route('status-permohonan-adm-delete', ['id' =>$data->id]);
                $route_softdelete = route('status-permohonan-adm-soft-delete', ['id' =>$data->id]);
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
            ->rawColumns(['update', 'delete'])
            ->toJson();
        // return DataTables::of($data)
        //     ->addColumn('update', $updated)
        //     ->addColumn('delete', $deleted)
        //     ->rawColumns(['update', 'delete'])
        //     ->toJson();

    }    
}
