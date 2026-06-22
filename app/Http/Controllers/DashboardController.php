<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Admin, Project, Notification, Client};
use DB;


class DashboardController extends Controller
{
    public $data;

    public function dashboard(){

        $auth_user = auth()->guard('admin')->user();
        $latest_project = Notification::select('id','title', 'message', 'created_at', 'table_id')->where('table_name', 'projects')->orderBy('created_at', 'desc')->get();

        $readCount = Notification::where('table_name', 'projects')->where('is_read', '1')->count();

        $this->data['latest_project'] = $latest_project;
        $this->data['latest_pro_read_count'] = $readCount;

        if(isset($auth_user->role->name) && $auth_user->role->name == 'Super-admin'){
            $unapproved_project = Project::select('projects.id', 'notification_label', 'projects.created_at')->join('notifications', 'notifications.table_id', 'projects.id')->where('project_type', 'unapproved')
            ->where('table_name', 'projects')->orderBy('projects.created_at', 'desc')->get();
            
            $unapproved_client = Client::select('clients.id', 'title','message', 'clients.created_at')->join('notifications', 'notifications.table_id', 'clients.id')->where('client_type', 'unapproved')
            ->where('table_name', 'clients')->orderBy('clients.created_at', 'desc')->get();


            $readCountProUnaproved = Project::join('notifications', 'notifications.table_id', '=', 'projects.id')->where('project_type', 'unapproved')
                        ->where('table_name', 'projects')->where('notifications.is_read', '1')->count();

            $readCountClient = Client::join('notifications', 'notifications.table_id', '=', 'clients.id')
                        ->where('client_type', 'unapproved')->where('table_name', 'clients')->where('notifications.is_read', '1')->count();

            $totalProject = Project::count();

            $this->data['read_count_client'] = $readCountClient;
            $this->data['read_count_pro_unaproved'] = $readCountProUnaproved;
            $this->data['unapproved_project'] = $unapproved_project;
            $this->data['unapproved_client'] = $unapproved_client;
            $this->data['total_project'] = $totalProject;
            $this->data['is_admin_dashboard'] = $this->data['is_latest_pro'] = true;
            $this->data['is_unapproved_project'] = $this->data['is_unapproved_client'] = false;

            return view('admin_dashboard', $this->data);
        }

        return view('user_dashboard', $this->data);
    }

    public function dashboardRead(Request $request){
        // dd(11);
        $tab_type = $request->tab_type ?? null;

        if($tab_type && $tab_type == 'latest_project'){
            Notification::where('is_read', '1')->where('table_name', 'projects')->update(['is_read' => '0']);

            return response()->json(['success' => $tab_type]);
        }

        if($tab_type && $tab_type == 'unapproved_project'){
            DB::table('notifications')->where('table_name', 'projects')->where('is_read', '1')->whereIn('table_id', function ($query) {
                    $query->select('id')
                        ->from('projects')
                        ->where('project_type', 'unapproved');
                })->update([
                    'is_read' => '0'
                ]);            

            return response()->json(['success' => $tab_type]);
        }

        if($tab_type && $tab_type == 'unapproved_client'){
            DB::table('notifications')->where('table_name', 'clients')->where('is_read', '1')
                ->whereIn('table_id', function ($query) {
                    $query->select('id')
                        ->from('clients')
                        ->where('client_type', 'unapproved');
                })->update([
                    'is_read' => '0'
                ]);

            return response()->json(['success' => $tab_type]);
        }

        return response()->json(['error' => false]);
    }
}
