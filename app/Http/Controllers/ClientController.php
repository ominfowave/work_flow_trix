<?php

namespace App\Http\Controllers;

use App\Models\{Client, Notification, Admin, Project};
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('permission:client-view,admin')->only(['index', 'show']);
        $this->middleware('permission:client-add,admin')->only(['create', 'store']);
        $this->middleware('permission:client-edit,admin')->only(['edit', 'update']);
        $this->middleware('permission:client-delete,admin')->only(['destroy']);
    }

    public function index()
    {
        $clients = Client::select('id', 'name', 'email', 'phone', 'status')->get();
        $this->data['clients'] = $clients;

        return view('client.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('client.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email',
                'phone' => 'required|min:10',
                'password' => 'required|min:6'
            ]);

            $input = $request->all();
            $input['password'] = md5($request->password);
            $input['status'] = $request->status ?? 'inactive';
    
            $admin = auth()->guard('admin')->user()->name ?? null;
            if($admin && $admin == 'vishal'){
                $input['client_type'] = 'approved';
            }

            $client = Client::create($input);

            // notification
            $user = auth()->guard('admin')->user();
            $superAdmin = Admin::select('id', 'name')->where('name', 'vishal')->first();

            $email = $request->email ?? '';
            $phone = $request->phone ?? '';

            if($superAdmin->name !== $user->name){
                $notification = [
                    'user_id' => $user->id,
                    'sender_id' => $user->id,
                    'receiver_id' => $superAdmin->id,
                    'title' => $request->name ?? '',
                    'message' => $email .'<br>'. $phone,
                    'notification_label' => $user->name . ' has been added a new client ' . '<b>'. $request->name .'</b>',
                    'table_id' => $client->id,
                    'table_name' => 'clients',
                    'is_read' => '1'
                ];
    
                Notification::create($notification);
            }
    
            return redirect()->route('client.index')->with(['success' => 'Client has been added successfully!']);
        } catch (\Illuminate\Validation\ValidationException $th) {

            return redirect()->back()->with(['error' => $th->validator->errors()->all()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $client = Client::find($id);
        $this->data['client'] = $client;

        return view('client.edit', $this->data); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        try{
            $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email',
                'phone' => 'required|min:10',
                'password' => 'nullable|min:6'
            ]);

            $input = [
                'name'  => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => $request->status ?? 'inactive'
            ];

                
            $client = Client::find($id);

            if($request->filled('password')){
                $input['password'] = md5($request->password);
            }

            $client->update($input);

            return redirect()->route('client.index')->with(['success' => 'Client has been updated successfully!']);

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
            $isUsedCliendId = Project::where('client_id', $id)->exists();

            if(!$isUsedCliendId){
                $client = Client::find($id);
                $client->delete();
        
                return response()->json(['success' => 'Client has been deleted successfully!']);
            }else{
                return response()->json(['error' => "This client is used in the Project module, so we can't remove it."]);
            }
        } catch (\Throwable $th) {

            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function clientStatus(Request $request){
        try {
            $id = $request->id;
            $status = $request->status;

            Client::where('id', $id)->update(['status' => $status]);

            return response()->json(['success' => 'Client status has been Updated successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function acceptClientReq(Request $request){
        try {
            $id = $request->project_id;

            Client::where('id', $id)->update(['client_type' => 'accept']);

            return response()->json(['success' => 'Client status has been Updated successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function rejectReasonClient(Request $request){
        try {
            $id = $request->project_id;
            $reason = $request->reason;

            if($reason !== '' && $id){
                Client::where('id', $id)->update(['client_type' => 'reject','reject_reason' => $reason]);
            }

            return response()->json(['success' => 'Reject reason has been Updated successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

}
