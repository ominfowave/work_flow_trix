<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Project, ProjectTimeline, ProjectTimelineFile, Notification};
use Illuminate\Support\Facades\File;

class ProjectTimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $project = Project::select('id','project_name', 'description')->where('id', $id)->first();
        $project_timeline = ProjectTimeline::with('projectTimelineFile')->where('project_id', $id)->get();
        
        $this->data['project'] = $project;
        $this->data['project_timelines'] = $project_timeline;
        $this->data['user_id'] = auth()->guard('admin')->user()->id;


        return view('project_timeline.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $input = [
                'project_id' => $request->project_id,
                'message' => $request->message ?? '',
            ];

            if(!$request->hasFile('file') && !isset($request->message)){

                 return response()->json([
                    'error' => false,
                    'message' => 'Please upload a file or text'
                ]);
            }

            $users = auth()->guard('admin')->user();

            $input['sender_id'] = $users->id;

            $project_timeline = ProjectTimeline::create($input);
                
            if($request->hasFile('file')){
                foreach($request->file('file') as $file){
                    
                    $filename = time().'_'.$file->getClientOriginalName();
                    
                    $file->move(public_path('project_timeline'), $filename);
                    
                    $input_file = [
                        'project_timeline_id' => $project_timeline->id,
                        'file' => $filename
                    ];

                   ProjectTimelineFile::create($input_file);
                }
            }

            if($users->name !== 'vishal'){
                $superAdmin = Admin::select('id')->where('name', 'vishal')->first();
            }

              $notification = [
                'user_id' => $users->id,
                'sender_id' => $users->id,
                'receiver_id' => $superAdmin->id ?? $users->id,
                'title' => $request->project_name ?? '',
                'message' => $request->message ?? '',
                'notification_label' => $users->name . ' has been added a Project Timeline ' . '<b>'. $request->project_name .'</b>',
                // 'table_id' => null,
                // 'table_name' => '',
                'is_read' => '0'
            ];

            Notification::create($notification);

            $project_timeline = ProjectTimeline::with('projectTimelineFile')->find($project_timeline->id);
            // dd($project_timeline);


            return response()->json([
                'success' => true,
                'message' => 'Timeline added successfully.',
                'data' => $project_timeline
            ]);
        } catch (\Throwable $th) {
           return response()->json([
                'error' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $projectTimeline = ProjectTimeline::with('projectTimelineFile')->find($id);
        
        return response()->json($projectTimeline);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        try{
            $input = [
                'message' => $request->message ?? '',
            ];

            if(!$request->hasFile('file') && !isset($request->message)){

                    return response()->json([
                    'error' => false,
                    'message' => 'Please upload a file or text'
                ]);
            }

            if(isset($request->delete_file_ids)){
                $delete_file_exp = explode(",",$request->delete_file_ids);

                foreach($delete_file_exp as $dlt_file){
                    $proTimelineFile = ProjectTimelineFile::find($dlt_file);
                    $path = public_path('project_timeline/'.$proTimelineFile->file);
                        
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                    $proTimelineFile->delete();
                }

            }
                
            if($request->hasFile('file')){
                foreach($request->file('file') as $file){
                    
                    $filename = time().'_'.$file->getClientOriginalName();
                    
                    $file->move(public_path('project_timeline'), $filename);
                    
                    $input_file = [
                        'project_timeline_id' => $id,
                        'file' => $filename
                    ];

                   ProjectTimelineFile::create($input_file);
                }
            }

            $project_timeline = ProjectTimeline::with('projectTimelineFile')->find($id);
            $project_timeline->update($input);

          return response()->json([
                'success' => true,
                'message' => 'Timeline updated successfully.',
                'data' => $project_timeline
            ]);
        } catch (\Throwable $th) {
           return response()->json([
                'error' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         try {
            $projectTimeline = ProjectTimeline::find($id, ['file', 'id']);
            $projectTimelineExp = explode(",", $projectTimeline->file);

            foreach ($projectTimelineExp as $project_timeline_file) {
                $path = public_path('project_timeline/'.$project_timeline_file);
                
                if (File::exists($path)) {
                    File::delete($path);
                }
            }
            
            $projectTimeline->delete();

            return response()->json(['success' => 'Project Timeline has been deleted successfully!']);
        } catch (\Throwable $th) {

            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
