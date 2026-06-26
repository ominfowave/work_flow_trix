<?php

namespace App\Http\Controllers;

use App\Models\{Project, Client, Admin, ProjectFile, Notification};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $project = Project::with(['productFile', 'getClient', 'getUser']);
        $user = auth()->guard("admin")->user();

        if(!$user->hasRole('Super-admin')){
            $project = $project->where('user_id', $user->id);
        }

        $project = $project->get();
        
        $this->data['project'] = $project;

        return view('project.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = Admin::select('name', 'id')->where('status', 'active')->get();
        $clients = Client::select('name', 'id')->where('status', 'active')->get();

        $this->data['users'] = $users;
        $this->data['clients'] = $clients;

        return view('project.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
             $request->validate([
                'project_name' => 'required',
                'assigned_team_members' => 'required',
                'client_id' => 'required'
            ]);

            $input = $request->except(['_token', 'images']);

            $user = auth()->guard('admin')->user();
            $admin = $user->name ?? null;
            if($admin && $admin == 'vishal'){
                $input['project_type'] = 'approved';
            }
            $input['user_id'] = $user->id;
            
            $project = Project::create($input);

            if ($request->file('images')) {

                foreach ($request->file('images') as $image) {
                    $name = time() . '_' . $image->getClientOriginalName();

                    $path = public_path('project_file');
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    
                    ProjectFile::create([
                        'project_id' => $project->id,
                        'file_name'  => $name,
                    ]);

                    $image->move(public_path('project_file'), $name);

                }
            }

            if($user->name !== 'vishal'){
                $superAdmin = Admin::select('id')->where('name', 'vishal')->first();
            }

            if(isset($superAdmin) && $superAdmin->name !== $user->name){

                $notification = [
                    'user_id' => $user->id,
                    'sender_id' => $user->id,
                    'receiver_id' => $superAdmin->id ?? $user->id,
                    'title' => $request->project_name ?? '',
                    'message' => $request->description ?? '',
                    'notification_label' => $user->name . ' has been added a new Project ' . '<b>'. $request->project_name .'</b>',
                    'table_id' => $project->id,
                    'table_name' => 'projects',
                    'is_read' => '1'
                ];

                Notification::create($notification);
            }

            return redirect()->route('project.index')->with(['success' => 'Project has been added successfully!']);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return redirect()->back()->with(['error' => $th->validator->errors()->all()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $project = Project::with(['productFile'])->find($id);
        $users = Admin::select('name', 'id')->where('status', 'active')->get();
        $clients = Client::select('name', 'id')->where('status', 'active')->get();

        $this->data['users'] = $users;
        $this->data['clients'] = $clients;
        $this->data['project'] = $project;

        return view('project.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
             $request->validate([
                'project_name' => 'required',
                'assigned_team_members' => 'required',
                'client_id' => 'required'
            ]);
            
            $input = $request->except(['_token', 'images', 'delete_file']);
            $project = Project::find($id);

            if(isset($request->delete_file)){
                $delete_file_id = explode(",", $request->delete_file);

                foreach($delete_file_id as $delete_id){
                   $file_name_old = ProjectFile::select('file_name')->where('id', $delete_id)->first();
                    $path = public_path('project_file/'.$file_name_old->file_name);

                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }

                ProjectFile::whereIn('id', $delete_file_id)->delete();
            }

            if ($request->file('images')) {

                foreach ($request->file('images') as $image) {
                    $name = time() . '_' . $image->getClientOriginalName();

                    $path = public_path('project_file');
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    
                    ProjectFile::create([
                        'project_id' => $id,
                        'file_name'  => $name,
                    ]);

                    $image->move(public_path('project_file'), $name);

                }
            }

            $project->update($input);

            return redirect()->route('project.index')->with(['success' => 'Project has been updated successfully!']);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return redirect()->back()->with(['error' => $th->validator->errors()->all()])->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $projectFiles = ProjectFile::select('file_name')->where('project_id', $id)->get();
            foreach ($projectFiles as $projectFile) {
                $path = public_path('project_file/'.$projectFile->file_name);
                
                if (File::exists($path)) {
                    File::delete($path);
                }
            }
            ProjectFile::where('project_id', $id)->delete();

            Project::where('id', $id)->delete();

            return response()->json(['success' => 'Project has been deleted successfully!']);
        } catch (\Throwable $th) {

            return response()->json(['error' => $th->getMessage()]);
        }
    }

    
    public function projectStatus(Request $request){
        try {
            $id = $request->id;
            $status = $request->status;

            Project::where('id', $id)->update(['status' => $status]);

            return response()->json(['success' => 'Project status has been Updated successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function acceptProReq(Request $request){
        try {
            $id = $request->project_id;

            Project::where('id', $id)->update(['project_type' => 'accept']);

            return response()->json(['success' => 'Project status has been Updated successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    
    public function rejectReasonPro(Request $request){
        try {
            $id = $request->project_id;
            $reason = $request->reason;

            if($reason !== '' && $id){
                Project::where('id', $id)->update(['project_type' => 'reject','reject_reason' => $reason]);
            }

            return response()->json(['success' => 'Reject reason has been Updated successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

}
