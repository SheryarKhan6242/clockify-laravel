<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Roles\CreateRequest;
use App\Http\Requests\Roles\EditRequest;

class RoleManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['roles'] = Role::where('name','!=','super-admin')->paginate(15);
        return view('roles-management.index',$data);
    }

    public function get_role_data(Request $request)
    {
        $roles = Role::paginate(15);

        if($request->ajax())
        {
            $roles = Role::query()
                        ->when($request->search_item, function($q)use($request){
                            $q->where('name','LIKE','%'.$request->search_item.'%');
                        })
                        ->paginate(15);

        }

        return view('roles-management.include.tableData', compact('roles'))->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data['permissions'] = Permission::all();
        return view('roles-management.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        // dd($request->all());
        $role = new Role();
        $role->name = $request->name;
        $role->guard_name = $request->guard_name ?? 'web';
        $role->save();

        if(is_array($request->permission_name)){
            foreach ($request->permission_names as $key => $permission_name) {
                $role->givePermissionTo($permission_name);
            }
        }

        return redirect()->route('roles-management.index')->with(['type' => 'success', 'message' => 'Role created successfully!']);
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

        $data['role'] = Role::find($id);
        $data['permissions'] = Permission::all();
        $data['selectedPermissions'] = $data['role']->permissions->pluck('id')->toArray();

        return view('roles-management.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditRequest $request, $id)
    {
        $role = Role::find($id);
        $role->name = $request->name;
        $role->guard_name = $request->guard_name ?? 'web';
        $role->save();

        $selectedPermissions = $request->input('permission_names', []);

        $removedPermissions = $role->permissions->pluck('id')->diff($selectedPermissions);
        $role->permissions()->detach($removedPermissions);
        
        $newPermissions = array_diff($selectedPermissions, $role->permissions->pluck('id')->toArray());
        $role->permissions()->attach($newPermissions);

        return redirect()->route('roles-management.index')->with(['type' => 'success', 'message' => 'Role saved successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        
        $role->syncPermissions([]);

        $role->destroy($id);

        return redirect()->route('roles-management.index')->with(['type' => 'success', 'message' => 'Role deleted successfully!']);
    }
}
