<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Permissions\CreateRequest;
use App\Http\Requests\Permissions\EditRequest;

class PermissionManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['permissions'] = Permission::paginate(15);
        // dd($data);
        return view('permissions-management.index',$data);
    }

    public function get_permissions_data(Request $request)
    {
        $permissions = Permission::paginate(15);

        if($request->ajax())
        {
            $permissions = Permission::query()
                        ->when($request->search_item, function($q)use($request){
                            $q->where('name','LIKE','%'.$request->search_item.'%');
                        })
                        ->paginate(15);

        }

        return view('permissions-management.include.tableData', compact('permissions'))->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions-management.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->guard_name = $request->guard_name ?? 'web';
        $permission->save();

        return redirect()->route('permissions-management.index')->with(['type' => 'success', 'message' => 'Permission created successfully!']);
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
        $data['permission'] = Permission::find($id);
        return view('permissions-management.edit',$data);
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
        $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->guard_name = $request->guard_name ?? 'web';
        $permission->save();

        return redirect()->route('permissions-management.index')->with(['type' => 'success', 'message' => 'Permission saved successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::destroy($id);
        return redirect()->route('permissions-management.index')->with(['type' => 'success', 'message' => 'Permission deleted successfully!']);
    }
}
