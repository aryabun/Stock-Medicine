<?php

namespace App\Domains\Auth\Http\Controllers\Backend\Permission;


use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Services\PermissionService;
use App\Domains\Auth\Services\RoleService;
use Illuminate\Http\Request;
use App\Domains\Auth\Models\User;

/**
 * Class RoleController.
 */
class PermissionController
{
    public function index()
    {
        $permissions=Permission::all();
        
        return response()->json($permissions);
        
    }
    public function store(Request $request)
    {
      
        $request->validate([
            "type" =>'required',
            "guard_name"=>'required' ,
            "name" =>'required',
            "description" =>'required',
            "parent_id"=>'required',
            "sort"=>'required'
        ]);
       $permission= new Permission();
       $permission->type = $request->type;
       $permission->guard_name = $request->guard_name;
       $permission->name = $request->name;
       $permission->description = $request->description;
       $permission->parent_id = $request->parent_id;
       $permission->sort = $request->sort;

       $permission->save();
         return response()->json($permission);  
    }
    public function update(Request $request,$id)
    {
        
        $request->validate([
            "type" =>'required',
            "guard_name"=>'required' ,
            "name" =>'required',
            "description" =>'required',
            "parent_id"=>'required',
            "sort"=>'required'
        ]);
        $permission= Permission::find($id);
        $permission->type = $request->type;
        $permission->guard_name = $request->guard_name;
        $permission->name = $request->name;
        $permission->description = $request->description;
        $permission->parent_id = $request->parent_id;
        $permission->sort = $request->sort;
        $permission->save();
        return response()->json($permission);
    }
    public function destroy($id)
    {
        $permission= Permission::find($id);
        $permission->delete();
        return response()->json([
            'status' => 'Success',
            'data' => $permission
        
        ]);
            
    }
}
