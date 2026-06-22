<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('role_or_permission:Super-admin,admin')->only(['index', 'show']);
        $this->middleware('role_or_permission:Super-admin,admin')->only(['create', 'store']);
        $this->middleware('role_or_permission:Super-admin,admin')->only(['edit', 'update']);
        $this->middleware('role_or_permission:Super-admin,admin')->only(['destroy']);
    }

    public function index()
    {
        $roles = Role::with('permissions')->where('name', '!=', 'Super-admin')->get();
        $this->data['roles'] = $roles;

        return view('role.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:100'
            ]);

            $input = $request->only('name');
            $input['guard_name'] = 'admin';

            $role = Role::create($input);

            foreach ($request->input('permissions', []) as $permission) {

                Permission::firstOrCreate([
                    'name' => $permission,
                    'guard_name' => 'admin'
                ]);
            }

            $role->syncPermissions($request->input('permissions', []));

            return redirect()->route("role.index")->with(['success' => 'Role has been added successfully!']);

        } catch (\Illuminate\Validation\ValidationException $th) {

            return redirect()->back()->with(['error' => $th->validator->errors()->all()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Role::find($id);
        abort_if($role->name == 'Super-admin', 401);

        $permissions = Permission::join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where('role_has_permissions.role_id', $id)->pluck('permissions.name')->toArray();

        $this->data['role'] = $role;
        $this->data['permissions'] = $permissions;

        return view('role.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         try{
            $request->validate([
                'name' => 'required|string|max:100'
            ]);

            $input = $request->only('name');
            $input['guard_name'] = 'admin';

            $role = Role::find($id);

            abort_if($role->name == 'Super-admin', 401);
            $role->update($input);

            foreach ($request->input('permissions', []) as $permission) {

                Permission::firstOrCreate([
                    'name' => $permission,
                    'guard_name' => 'admin'
                ]);
            }

            $role->syncPermissions($request->input('permissions', []));

            return redirect()->route("role.index")->with(['success' => 'Role has been updated successfully!']);

        } catch (\Illuminate\Validation\ValidationException $th) {

            return redirect()->back()->with(['error' => $th->validator->errors()->all()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        
    }

     public function roleStatus(Request $request){
        try {
            $id = $request->id;
            $status = $request->status;

            Role::where('id', $id)->update(['status' => $status]);

            return response()->json(['success' => 'Role status has been Updated successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
