<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RoleAndPermissinController extends Controller
{
    //
    public function roleSave(Request $request)
    {

        $get_permission=[];

        $get_request = $request->all();
        foreach($get_request as $key =>$value){
            if( $key  != "_token"  && $key  != "roleName"){
                $get_permission[] = $key;

            }

            


        }
        
        $add_role              = new Role();
        $add_role->guard_name  = 'web';
        $add_role->name        = $request->roleName;
        $add_role->save();



        foreach($get_permission as $get_permission){
            $add_permission              = new Permission();
            $add_permission->role_id     = $add_role->_id;
            $add_permission->name        = $get_permission;
            $add_permission->save();

        

        

            
        }
        dd($get_permission,$add_role->_id);

    }

}
