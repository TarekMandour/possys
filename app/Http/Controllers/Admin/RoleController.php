<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
  public function index()
  {
      // $query['data'] = Parents::orderBy('id','desc')->with('Category')->get();
      $query['data'] = Role::orderBy('id','desc')->get();
      // $query['data'] = Admin::orderBy('id','desc')->paginate(10);
      return view('admin.role.index',$query);
  }

  // public function show($id)
  // {
  //     // $query['data'] = Parents::with('Category')->find($id);
  //     $query['data'] = Role::find($id);
  //     return view('admin.role.show',$query);
  // }

  public function create()
  {
      $query['permissions'] = Permission::all();
      return view('admin.role.create', $query);
  }

  public function store(Request $request)
  { 

      // return $request;
      $this->validate($request, [
        'name' => 'required|string|unique:roles,name',
    ], [
        'name.unique' => 'اسم الصلاحية مُستخدم من قبل',
    ]);
      try {
        if(!empty($request->permissions)) {
          $role = Role::create(['name' => $request->name]);
          $permissions = Permission::whereIn('id', $request->permissions)->get();
          $permissionNames = $permissions->pluck('name')->toArray();
          $role->givePermissionTo($permissions);
        } else {
          $role = Role::create(['name' => $request->name]);
          $role->givePermissionTo([]);
        }
            $role->save();

            return redirect('admin/roles')->with('msg', 'تم بنجاح');
      } catch (\Exception $ex) {
          return $ex;
          return redirect('admin/roles')->with('msg', 'Failed');
      }
  }

  public function edit(Request $request)
  {
        $permissions = Permission::all();
        $role = Role::find($request->id); // replace 1 with the ID of the role you want to check
        return view('admin.role.edit', compact('permissions', 'role'));
  }

  public function update(Request $request)
  {

    
    $role = Role::find($request->id);

      $this->validate($request, [
          'name' => [
              'required',
              'string',
              Rule::unique('roles', 'name')->ignore($role->id),
          ],
      ], [
          'name.unique' => 'اسم الصلاحية مُستخدم من قبل',
      ]);

      
      try {

        if($role->name != $request->name) {
          $role = Role::where('id', $request->id)->update([
            'name' => $request->name,
          ]);  
        }


        if(!empty($request->permissions)) {
          $permissions = Permission::whereIn('id', $request->permissions)->get();

          $permissionNames = $permissions->pluck('name')->toArray();
  
          $role->syncPermissions($permissionNames);
        } else {
          $role->syncPermissions([]);
        }


        $role->save();
        return redirect('admin/roles')->with('msg', 'تم بنجاح');

      } catch (\Exception $ex) {
          return $ex;
          return redirect('admin/roles')->with('msg', 'Failed');
      }
  }

  public function delete(Request $request)
  {   

      try{
          Role::whereIn('id',$request->id)->delete();
      } catch (\Exception $e) {
          return response()->json(['msg'=>'Failed']);
      }
      return response()->json(['msg'=>'Success']);
  }

  protected function process(Role $data, Request $r) {
      $data->name = $r->name;
      $data->permissions = json_encode($r->permissions);
      $data->save();
      return $data;
  }
}
