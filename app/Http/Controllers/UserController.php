<?php

namespace App\Http\Controllers;

use App\Department;
use App\Repositories\UserRepo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $userRepo;

    public function __construct(
        UserRepo $userRepo
    ){
        $this->userRepo = $userRepo;
    }

    public function getList(){
        $roles = Role::all();
        $permissions = Permission::all();
        return view('site.users.all',compact('roles','permissions'));
    }

    public function getData(Request $request){
        $users = $this->userRepo->getDataTable($request);
        return DataTables::of($users)
            ->editColumn('email',function($user){
                return '<a href="mailto:'.$user->email.'">'.$user->email.'</a>';
            })
            ->editColumn('personal_email',function($user){
                return '<a href="mailto:'.$user->personal_email.'">'.$user->personal_email.'</a>';
            })
            ->editColumn('phone_number',function($user){
                return '<a href="tel:'.$user->phone_number.'">'.$user->phone_number.'</a>';
            })
            ->editColumn('roles',function($user){
                $roles = explode(',',$user->roles);
                $returnStr = '';
                foreach($roles as $role){
                    $returnStr .= '<span class="badge badge-info mx-1">'.__('global.roles.'.$role).'</span>';
                }
                return $returnStr;
            })
            ->editColumn('permissions',function($user){
                $permissions = explode(',',$user->permissions);
                $returnStr = '';
                foreach($permissions as $permission){
                    $returnStr .= '<span class="badge badge-warning mx-1">'.__('global.permissions.'.$permission).'</span>';
                }
                return $returnStr;
            })
            ->addColumn('actions',function($user){
                $returnStr = '<button class="btn btn-primary edit-btn mx-1" data-user-id="'.$user->id.'" ><i class="fas fa-pencil-alt"></i></button>';
                DB::beginTransaction();
                try{
                    $this->userRepo->delete(User::findOrFail($user->id));
                    $returnStr .= '<button class="btn btn-danger delete-btn mx-1" data-user-id="'.$user->id.'"><i class="fas fa-trash-alt"></i></button>';
                }catch(\Exception $e){

                }finally{
                    DB::rollback();
                }
                return $returnStr;
            })
            ->rawColumns(['email','personal_email','phone_number','roles','permissions','actions'])
            ->make(true);
    }

    public function postDelete(Request $request){
        try{
            $this->userRepo->delete(User::findOrFail($request->input('id')));
            return 'true';
        }catch(\Exception $e){
            return 'false';
        }
    }

    public function getEdit(Request $request){
        if($request->input('id')) $user = User::findOrFail($request->input('id'));
        else $user = null;
        $roles = Role::all();
        $permissions = Permission::all();
        $departments = Department::all();
        return view('site.users.edit',compact('roles','permissions','user','departments'));
    }

    public function postSave(Request $request){
        DB::beginTransaction();
        try{
            if($request->input('id')){
                $user = User::findOrFail($request->input('id'));
            }else{
                $user = new User();
            }
            $user->setName($request->input('name'));
            $user->setSurname($request->input('surname'));
            $user->setEmail($request->input('email'));
            $user->setPersonalEmail($request->input('personal_email'));
            $user->setAddress($request->input('address'));
            $user->setPhoneNumber($request->input('phone_number'));
            $user->setIdNumber($request->input('id_number'));
            $user->setDepartment($request->input('department_id'));
            $user = $this->userRepo->updateWithoutData($user);
            $user->syncRoles($request->input('roles'));
            $user->syncPermissions($request->input('permissions'));
            $this->userRepo->updateWithoutData($user);
            DB::commit();
            return 'true';
        }catch(\Exception $e){
            DB::rollBack();
            return $e;
        }
    }
}
