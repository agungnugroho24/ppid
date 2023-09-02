<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\DetailRoles;
use App\Models\DetailPermission;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Str;

class RolePermissionUserController extends Controller
{
    protected $title1 = "Pengolahan Role Pengguna Aplikasi PPID";
    protected $title2 = "Pengolahan Permission Pengguna Aplikasi PPID";
    protected $title3 = "Pengolahan Pemberian Role Ke Pengguna Aplikasi PPID";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back-office.pages.role_user_bo', ['title' => $this->title1]);
    }

    public function indexpermission()
    {
        return view('back-office.pages.permission_user_bo', ['title' => $this->title2]);
    }    

    public function indexAssignRole()
    {
        $roles = DB::table('roles')->get();
        return view('back-office.pages.assignrole_user_bo', ['title' => $this->title3, 'roles' => $roles]);
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

    public function createpermission()
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

    public function storepermission(Request $request)
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

    public function editpermission($id)
    {
        $data = DB::table('permissions')
            ->join('detail_permissions', 'detail_permissions.id_permissions', '=', 'permissions.id')
            ->where('permissions.id', $id)
            ->get();
            // dd($data);
        return view('back-office.forms.form_edit_permissiondetail_bo', ['title' => $this->title2, 'data' => $data]);
    }   

    public function editrole($id)
    {
        $data = DB::table('roles')
            ->join('detail_roles', 'detail_roles.id_roles', '=', 'roles.id')
            ->where('roles.id', $id)
            ->get();
            // dd($data);
        return view('back-office.forms.form_edit_roledetail_bo', ['title' => $this->title1, 'data' => $data]);
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

    public function updatepermission(Request $request, $id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update data.', 'error');
            return redirect()->route('permission-user-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['super-update']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update data.', 'error');
            return redirect()->route('permission-user-adm');            
        endif;

        $rules = [
            // 'permission' => 'required',
            'keterangan' => 'required',
        ];

        $messages = [
            // 'permission.required' => 'Field \':attribute\' tidak boleh kosong',
            'keterangan.required' => 'Field \':attribute\' tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);
        
        $data = array(
            'keterangan' => $request->keterangan,
        );

        $query = DetailPermission::where('id_permissions', $id)->update($data);

        if($query):
            Alert::toast('Update Data Permission Pengguna Aplikasi PPID Berhasil', 'success');
            return redirect()->route('permission-user-adm');
        else:
            Alert::toast('Update Data Permission Pengguna Aplikasi PPID Gagal.!', 'error');
            return redirect()->route('permission-user-adm');
        endif;              
    }   

    public function updaterole(Request $request, $id)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update data.', 'error');
            return redirect()->route('role-user-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['super-update']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan update data.', 'error');
            return redirect()->route('role-user-adm');            
        endif;

        $rules = [
            // 'role' => 'required',
            'keterangan' => 'required',
        ];

        $messages = [
            // 'role.required' => 'Field \':attribute\' tidak boleh kosong',
            'keterangan.required' => 'Field \':attribute\' tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);
        
        $data = array(
            'keterangan' => $request->keterangan,
        );

        $query = DetailRoles::where('id_roles', $id)->update($data);

        if($query):
            Alert::toast('Update Data Role Pengguna Aplikasi PPID Berhasil', 'success');
            return redirect()->route('role-user-adm');
        else:
            Alert::toast('Update Data Role Pengguna Aplikasi PPID Gagal.!', 'error');
            return redirect()->route('role-user-adm');
        endif;              
    } 

    public function updatestatuspost(Request $request, $id)
    {
        //        
    } 

    public function updatestatuspostpermission(Request $request, $id)
    {
        //       
    }          

    public function updateassignrole(Request $request)
    {
        if(! auth()->user()->hasRole(['super-administrator', 'developer'])):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan assign role user.', 'error');
            return redirect()->route('assign-role-permission-adm');            
        endif;

        if(! auth()->user()->hasAnyPermission(['assign']) ):
            Alert::toast('Anda tidak memiliki wewenang untuk melakukan aassign role user.', 'error');
            return redirect()->route('assign-role-permission-adm');            
        endif; 

        $idrole_before = $request->idrole;
        $namerole_before = $request->namerolebefore;
        $namerole_after = $request->role_user;
        $iduser = $request->iduser;
        $user = User::findOrFail($iduser);
        if($user):
            $res1 = $user->removeRole($namerole_before);
            $res2 = $user->assignRole($namerole_after);
            if(($res1 == TRUE) && ($res2 == TRUE)):
                $response = TRUE;
            else:
                $response = FALSE;
            endif;
        else:
            $response = FALSE;
        endif;      

        if($response):
            Alert::toast('Assign Role Berhasil', 'success');
            return redirect()->route('assign-role-permission-adm');
        else:
            Alert::toast('Assign Role Gagal.!', 'error');
            return redirect()->route('assign-role-permission-adm');
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
        //
    }

    public function softdelete($id)
    {
        //
    }

    public function softdeletepermission($id)
    {
        //
    }

    public function getDatatablesJsonUserHasRole()
    {
        $roles = DB::table('model_has_roles')
            ->join('users', 'users.id', '=', 'model_has_roles.model_id')
            ->orderBy('users.id', 'DESC')
            ->groupBy('users.id')
            ->get();

        foreach($roles as $role):
            // $role_id = $role->role_id;
            $userid = $role->model_id;
            $roleid = $role->role_id;
            $name = $role->name;
            if(empty($roleid)):
                $permission = NULL;
                $haspermission = FALSE;
            else:
                $rolename = DB::table('roles')
                    ->select('name')
                    ->where('id', '=', $roleid)
                    ->get();                
                $haspermission = TRUE;
            endif;

            $data[] = [ 'idrole' => $roleid, 'iduser' => $userid, 'name' => $name, 'rolename' => $rolename ];

        endforeach;

        return DataTables::of($data)
            ->addColumn('update', function($data){
                $route_update = route('post-informasi-publik-edit', ['id' =>$data['iduser']]);
                if(auth()->user()->hasPermissionTo('assign')):
                    $updated = "<button class='btn btn-icon btn-sm btn-warning' title='Assign Role' data-toggle='modal' data-target='#statusRoleUser'><i class='far fa-edit'></i></button>";
                else:
                    $updated = "<button class='btn btn-icon btn-sm btn-warning disabled' title='Assign Role not-allowed' style='cursor:not-allowed' data-toggle='tooltip'><i class='far fa-edit'></i></button>";
                endif;     
                return $updated;           
            })          
            ->addColumn('role_name', function($data){

                 if($data['rolename']):
                    foreach($data['rolename'] as $row):
                        $name = $row->name;
                    endforeach;
                    $role_name = $name;
                    $strname = Str::contains($role_name, '-');
                    if($strname):
                        $namereplaced = Str::replace('-', ' ', $role_name);
                        $role_name = Str::ucfirst($namereplaced);
                    else:
                        $role_name = Str::ucfirst($role_name);
                    endif;
                endif;     
                return $role_name;           
            })  
            ->addColumn('route_update_role', function($data){
                $route_update_role = route('assign-role-permission-adm-update');    
                return $route_update_role;           
            })            
            ->rawColumns(['update','role_name','route_update_role'])                 
            ->toJson();

    }

    public function getDatatablesJsonRole()
    {
        $roles = DB::table('roles')
            ->leftjoin('role_has_permissions', 'role_has_permissions.role_id', '=', 'roles.id')
            ->orderBy('roles.id', 'ASC')
            ->groupBy('roles.id')
            ->get();

        foreach($roles as $role):
            $permission_id = $role->permission_id;
            $roleid = $role->id;
            $rolename = $role->name;
            if(empty($permission_id)):
                $permission = NULL;
                $haspermission = FALSE;
            else:
                $permission = DB::table('role_has_permissions')
                    ->select('name')
                    ->join('permissions', function ($join) {
                        $join->on('role_has_permissions.permission_id', '=', 'permissions.id');
                    })
                    ->where('role_id', '=', $roleid)
                    ->get();                
                $haspermission = TRUE;
            endif;

            $data[] = [ 'idrole' => $roleid, 'rolename' => $rolename, 'haspermission' => $haspermission, 'permission' => $permission ];

        endforeach;

        return DataTables::of($data)      
            ->addColumn('permission_name', function($data){

                if($data['haspermission']):
                        $name = '';
                    foreach($data['permission'] as $row):
                        $name .= '<li>'.$row->name.'</li>';
                    endforeach;
                    $permissionname = $name;
                else:
                    // $permissionname = $data['permission'];
                    $permissionname = 'Belum memiliki permission';
                endif;     
                return $permissionname;           
            })  
            ->addColumn('keterangan', function($data){

                if(!empty($data['idrole'])):
                    $id = $data['idrole'];
                    $query = DetailRoles::where('id_roles', $id)->get();
                    // dd($query);
                    $keterangan = $query[0]->keterangan;
                else:
                    $keterangan = NULL;
                endif;     
                return $keterangan;           
            }) 
            ->addColumn('update', function($data){
                $route_update = route('role-user-adm-edit', ['id' =>$data['idrole']]);
                if(auth()->user()->hasPermissionTo('super-update')):
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data' data-toggle='tooltip'><i class='far fa-edit'></i></a>";
                else:
                    $updated = "<button class='btn btn-icon btn-sm btn-warning disabled' title='Update Data not-allowed' style='cursor:not-allowed' data-toggle='tooltip'><i class='far fa-edit'></i></button>";
                endif;     
                return $updated;           
            })                       
            ->rawColumns(['permission_name', 'update', 'keterangan'])                 
            ->toJson();

    }

    public function getDatatablesJsonPermission()
    {
        $data = DB::table('permissions')
            ->join('detail_permissions', 'detail_permissions.id_permissions', '=', 'permissions.id')
            ->select([
                'permissions.id',
                'detail_permissions.keterangan',
                'permissions.name',
                'permissions.guard_name',
                'permissions.created_at',
                'permissions.updated_at',
            ])
            ->orderBy('permissions.id', 'DESC')
            ->get();
            // dd($data);
        
        return DataTables::of($data)
            ->addColumn('update', function($data){
                $route_update = route('permission-user-adm-edit', ['id' =>$data->id]);
                if(auth()->user()->hasPermissionTo('super-update')):
                    $updated = "<a href='$route_update' class='btn btn-icon btn-sm btn-warning' title='Update Data' data-toggle='tooltip'><i class='far fa-edit'></i></a>";
                else:
                    $updated = "<button class='btn btn-icon btn-sm btn-warning disabled' title='Update Data not-allowed' style='cursor:not-allowed' data-toggle='tooltip'><i class='far fa-edit'></i></button>";
                endif;     
                return $updated;           
            })
            // ->addColumn('delete', function($data){
            //     $route_delete = route('post-informasi-publik-delete', ['id' =>$data->id]);
            //     $route_softdelete = route('post-informasi-publik-soft-delete', ['id' =>$data->id]);
            //     if(auth()->user()->hasPermissionTo('soft-delete')):
            //         $deleted = "<a href='$route_softdelete' class='btn btn-icon btn-sm btn-danger soft-delete-confirm' title='Soft Delete' data-toggle='tooltip'><i class='far fa-trash-alt'></i></a>";
            //     elseif(auth()->user()->hasPermissionTo('hard-delete')):
            //         $soft_deleted = "<a href='$route_softdelete' class='btn btn-icon btn-sm btn-danger soft-delete-confirm' title='Soft Delete' data-toggle='tooltip'><i class='far fa-trash-alt'></i></a>";

            //         $hard_deleted = "<a href='$route_delete' class='btn btn-icon btn-sm btn-custom-2 hard-delete-confirm' title='Hard Delete' data-toggle='tooltip'><i class='fas fa-eraser'></i></a>";

            //         $deleted = $soft_deleted.' &#9474; '.$hard_deleted;
            //     else:
            //         $deleted = "<button class='btn btn-icon btn-sm btn-danger disabled' title='Delete not-allowed' style='cursor:not-allowed' data-toggle='tooltip'><i class='far fa-trash-alt'></i></button>";
            //     endif;    
            //     return $deleted;            
            // })
            // ->addColumn('publish', function($data){
            //     $route_publish = route('post-informasi-publik-publish', ['id' =>$data->id]);
            //     if(auth()->user()->hasPermissionTo('publish')):
            //         if($data->is_publish == 0):
            //             $published = "<a href='$route_publish' class='btn btn-icon btn-sm btn-custom-1' title='Published' data-toggle='tooltip'><i class='fas fa-share-square'></i></a>";
            //         else:
            //             $published = "<a href='$route_publish' class='btn btn-icon btn-sm btn-custom-3' title='Unpublished' data-toggle='tooltip'><i class='fas fa-share-square'></i></a>";
            //         endif;
            //     else:
            //         $published = "<button class='btn btn-icon btn-sm btn-secondary disabled' title='Publish Content not-allowed' data-toggle='tooltip'><i class='fas fa-share-square' style='cursor:not-allowed'></i></button>";
            //     endif;    
            //     return $published;            
            // })           
            ->rawColumns(['update', 'keterangan'])
            ->toJson();

    }         

}
