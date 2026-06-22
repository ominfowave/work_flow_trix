<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\{Tech, Admin};
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('role_or_permission:Super-admin|user-view,admin')->only(['index', 'show']);
        $this->middleware('role_or_permission:Super-admin|user-add,admin')->only(['create', 'store']);
        $this->middleware('role_or_permission:Super-admin|user-edit,admin')->only(['edit', 'update']);
        $this->middleware('role_or_permission:Super-admin|user-delete,admin')->only(['destroy']);
    }

    public function index()
    {
        $admins = Admin::with('role')->whereHas('role', function($query) {
             $query->where('name', '!=', 'Super-admin');
        })->get();
        
        $this->data['admins'] = $admins;

        return view('admin.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('name', '!=', 'Super-admin')->where('status', 'active')->pluck('name', 'id')->toArray();
        $techs = Tech::pluck('tech_name', 'id')->where('status', 'active')->toArray();

        $this->data['roles'] = $roles;
        $this->data['techs'] = $techs;

        return view('admin.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:100',
                'full_name' => 'required|string|max:100',
                'password' => 'required|string|min:6',
                'role_id' => 'required',
                'tech_id' => 'required'         
            ]);

            $input = $request->only('name', 'full_name', 'password', 'role_id', 'tech_id', 'status');
            $input['password'] = bcrypt($input['password']);
            $input['status'] = $request->status ?? 'inactive';

            $admin = Admin::create($input);
            $role = Role::select('name')->where('id', $input['role_id'])->first();

            $admin->assignRole($role->name);

            return redirect()->route("admin.index")->with(['success' => 'User has been added successfully!']);

        } catch (\Illuminate\Validation\ValidationException $th) {
            return back()->withErrors($th->validator)->withInput();            
        }
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $roles = Role::pluck('name', 'id')->toArray();
        $techs = Tech::pluck('tech_name', 'id')->toArray();

        $this->data['admin'] = $admin;
        $this->data['roles'] = $roles;
        $this->data['techs'] = $techs;

        return view('admin.edit', $this->data);
    }

    public function update(Request $request, $id){
        try {
            $request->validate([
                'name' => 'required|string|max:100',
                'full_name' => 'required|string|max:100',
                'password' => 'nullable|string|min:6',
                'role_id' => 'required',
                'tech_id' => 'required'  
            ]);
            $admin = Admin::find($id);

            $input = $request->only('name', 'full_name', 'password', 'role_id', 'tech_id', 'status');

            $input = [
                'name' => $request->name ?? '',
                'full_name' => $request->full_name ?? '',
                'role_id' => $request->role_id ?? '',
                'tech_id' => $request->tech_id ?? '',
                'status' => $request->status ?? 'inactive',
            ];

            if($request->input('password')){
                $input['password'] = bcrypt($request->input('password'));
            }

            $role = Role::select('name')->where('id', $input['role_id'])->first();
            $admin->assignRole($role->name);

            $admin->update($input);

            return redirect()->route('admin.index')->with(['success' => 'User has been updated successfully!']);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return back()->withErrors($th->validator)->withInput();            
        }
    }

    public function destroy($id){
        try{
            $admin = Admin::find($id);
            $admin->delete();

            return response()->json(['success' => 'Admin has been deleted successfully!']);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return back()->withErrors($th->validator)->withInput();            
        }
    }

    public function adminStatus(Request $request){
        try {
            $id = $request->id;
            $status = $request->status;

            Admin::where('id', $id)->update(['status' => $status]);

            return response()->json(['success' => 'User status has been Updated successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
