<?php

namespace App\Http\Controllers;

use App\Models\Tech;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TechController extends Controller
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
        $tech = Tech::get();
        $this->data['techs'] = $tech; 

        return view('tech.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('tech.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'tech_name' => 'required|string|max:100',
                'tech_icon' => 'nullable|mimes:jpg,jpeg,png'
            ]);

            $input = $request->all();
            $input['status'] = $request->status ?? 'inactive';


            if($request->hasFile('tech_icon')){
                $time = date('YmdHis');
                $original_name = $request->tech_icon->getClientOriginalName();
                $extension = $request->tech_icon->getClientOriginalExtension();
                $icon_name = pathinfo($original_name, PATHINFO_FILENAME) . '_' . $time . '.' . $extension;
                $path = public_path('tech_image');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $request->tech_icon->move($path, $icon_name);
                $input['tech_icon'] = $icon_name;
            }

            Tech::create($input);

           return redirect()->route('tech.index')->with(['success' => 'Tech has been added successfully!']);
        } catch (\Illuminate\Validation\ValidationException $th) {

            return redirect()->back()->with(['error' => $th->validator->errors()->all()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tech $tech)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tech = Tech::find($id);
        $this->data['tech'] = $tech;
        
        return view('tech.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         try{

            $request->validate([
                'tech_name' => 'required|string|max:100',
                'tech_icon' => 'nullable|mimes:jpg,jpeg,png'
            ]);

            $input = $request->all();
            $tech = Tech::find($id);

            $input = [
                'tech_name'  => $request->tech_name,
                'status' => $request->status ?? 'inactive'
            ];

            if($request->hasFile('tech_icon')){
                $time = date('YmdHis');
                $original_name = $request->tech_icon->getClientOriginalName();
                $extension = $request->tech_icon->getClientOriginalExtension();
                $icon_name = pathinfo($original_name, PATHINFO_FILENAME) . '_' . $time . '.' . $extension;
                $path = public_path('tech_image');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $request->tech_icon->move($path, $icon_name);
                $input['tech_icon'] = $icon_name;

                
                if(isset($tech->tech_icon)){
                    $oldImagePath = public_path('tech_image/' . $tech->tech_icon);
                    if(File::exists($oldImagePath)){    
                        File::delete($oldImagePath);
                    }
                }
            }

            

            $tech->update($input);

           return redirect()->route('tech.index')->with(['success' => 'Tech has been updated successfully!']);
        } catch (\Illuminate\Validation\ValidationException $th) {

            return redirect()->back()->with(['error' => $th->validator->errors()->all()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tech $tech)
    {
        //
    }

    public function techStatus(Request $request){
        try {
            $id = $request->id;
            $status = $request->status;

            Tech::where('id', $id)->update(['status' => $status]);

            return response()->json(['success' => 'Tech status has been Updated successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
